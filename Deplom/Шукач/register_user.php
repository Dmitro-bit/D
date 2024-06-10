<?php
session_start();

header('Content-Type: application/json');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    error_log("Помилка з'єднання: " . $conn->connect_error);
    echo json_encode(["status" => "error", "message" => "Помилка з'єднання з базою даних"]);
    exit();
}

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['email'])) {
    $email = $data['email'];
    $checkEmailStmt = $conn->prepare("SELECT id_user FROM user WHERE gmail = ?");
    if ($checkEmailStmt === false) {
        echo json_encode(["status" => "error", "message" => "Помилка підготовки запиту"]);
        exit();
    }

    $checkEmailStmt->bind_param("s", $email);
    if (!$checkEmailStmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Помилка виконання запиту"]);
        exit();
    }

    $result = $checkEmailStmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "exists"]);
    } else {
        echo json_encode(["status" => "available"]);
    }

    $checkEmailStmt->close();
    $conn->close();
    exit();
}

if (isset($data['phone'])) {
    $phone = $data['phone'];
    $checkPhoneStmt = $conn->prepare("SELECT id_user FROM user WHERE fone = ?");
    if ($checkPhoneStmt === false) {
        echo json_encode(["status" => "error", "message" => "Помилка підготовки запиту"]);
        exit();
    }

    $checkPhoneStmt->bind_param("s", $phone);
    if (!$checkPhoneStmt->execute()) {
        echo json_encode(["status" => "error", "message" => "Помилка виконання запиту"]);
        exit();
    }

    $result = $checkPhoneStmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "exists"]);
    } else {
        echo json_encode(["status" => "available"]);
    }

    $checkPhoneStmt->close();
    $conn->close();
    exit();
}

$name = $_POST['name'];
$surname = $_POST['surname'];
$fone = $_POST['fone'];
$gmail = $_POST['gmail'];
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

if (isset($_FILES['rezyme']) && $_FILES['rezyme']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['rezyme']['tmp_name'];
    $fileData = file_get_contents($fileTmpPath);
    $fileSize = $_FILES['rezyme']['size'];

    if ($fileSize > 5 * 1024 * 1024) {
        echo json_encode(["status" => "error", "message" => "Розмір файлу перевищує допустимий ліміт"]);
        exit();
    }
} else {
    echo json_encode(["status" => "error", "message" => "Помилка завантаження файлу резюме"]);
    exit();
}

try {
    $checkEmailStmt = $conn->prepare("SELECT id_user FROM user WHERE gmail = ?");
    if ($checkEmailStmt === false) {
        throw new Exception("Помилка підготовки запиту: " . $conn->error);
    }

    $checkEmailStmt->bind_param("s", $gmail);
    if (!$checkEmailStmt->execute()) {
        throw new Exception("Помилка виконання запиту: " . $checkEmailStmt->error);
    }

    $result = $checkEmailStmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Такий імейл вже зареєстрований"]);
        exit();
    }

    $checkEmailStmt->close();

    $checkPhoneStmt = $conn->prepare("SELECT id_user FROM user WHERE fone = ?");
    if ($checkPhoneStmt === false) {
        throw new Exception("Помилка підготовки запиту: " . $conn->error);
    }

    $checkPhoneStmt->bind_param("s", $fone);
    if (!$checkPhoneStmt->execute()) {
        throw new Exception("Помилка виконання запиту: " . $checkPhoneStmt->error);
    }

    $result = $checkPhoneStmt->get_result();
    if ($result->num_rows > 0) {
        echo json_encode(["status" => "error", "message" => "Такий номер телефону вже зареєстрований"]);
        exit();
    }

    $checkPhoneStmt->close();

    $stmt = $conn->prepare("INSERT INTO user (name, surname, fone, gmail, password, rezyme) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception("Помилка підготовки запиту: " . $conn->error);
    }

    $stmt->bind_param("sssssb", $name, $surname, $fone, $gmail, $hashed_password, $fileData);
    $stmt->send_long_data(5, $fileData);

    if (!$stmt->execute()) {
        throw new Exception("Помилка виконання запиту: " . $stmt->error);
    }

    $user_id = $stmt->insert_id;
    $stmt->close();

    $_SESSION['user_name'] = $name;
    $_SESSION['user_surname'] = $surname;
    $_SESSION['user_id'] = $user_id;

    echo json_encode(["status" => "success", "message" => "Реєстрація пройшла успішно"]);
    exit();

} catch (Exception $e) {
    error_log("Помилка: " . $e->getMessage());
    echo json_encode(["status" => "error", "message" => "Помилка: " . $e->getMessage()]);
    exit();
}

$conn->close();
?>
