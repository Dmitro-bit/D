<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

header('Content-Type: application/json');

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id_admin FROM admin WHERE gmail = ?");
    if ($stmt === false) {
        die(json_encode(["status" => "error", "message" => "Помилка підготовки запиту: " . $conn->error]));
    }

    $stmt->bind_param("s", $gmail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->close();
        echo json_encode(["status" => "error", "message" => "Користувач із таким email вже існує."]);
        exit();
    }

    $stmt->close();

    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    try {
        $stmt = $conn->prepare("INSERT INTO admin (name, surname, gmail, password) VALUES (?, ?, ?, ?)");
        if ($stmt === false) {
            throw new Exception("Помилка підготовки запиту: " . $conn->error);
        }

        $stmt->bind_param("ssss", $name, $surname, $gmail, $hashed_password);
        if (!$stmt->execute()) {
            throw new Exception("Помилка виконання запиту: " . $stmt->error);
        }

        $stmt->close();
        $_SESSION['admin_id'] = $conn->insert_id;
        echo json_encode(["status" => "success", "message" => "Реєстрація пройшла успішно!"]);
    } catch (Exception $e) {
        error_log("Помилка: " . $e->getMessage());
        echo json_encode(["status" => "error", "message" => "Помилка: " . $e->getMessage()]);
    }
}

$conn->close();
?>
