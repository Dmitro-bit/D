<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Будь ласка, увійдіть або зареєструйтесь як адміністратор."]);
    exit();
}

$adminId = $_SESSION['admin_id'];

$input = json_decode(file_get_contents('php://input'), true);
$vacancyId = isset($input['vacancy_id']) ? intval($input['vacancy_id']) : 0;
$userId = isset($input['user_id']) ? intval($input['user_id']) : 0;

if ($vacancyId > 0 && $userId > 0) {
    $sql = "UPDATE user_favorites SET vak = NULL WHERE vacancy_id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ii", $vacancyId, $userId);

        if ($stmt->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Помилка виконання запита: " . $stmt->error]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Помилка підготовка запита: " . $conn->error]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Некоректний ідентифікатор вакансії або користувача."]);
}

$conn->close();
?>
