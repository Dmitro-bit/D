<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Будьласка, увійдіть або зареєструйтесь."]);
    exit();
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $vacancy_id = isset($_POST['vacancy_id']) ? intval($_POST['vacancy_id']) : 0;
    $current_state = isset($_POST['current_state']) ? filter_var($_POST['current_state'], FILTER_VALIDATE_BOOLEAN) : false;

    if ($vacancy_id > 0) {
        if ($current_state) {
            $sql = "DELETE FROM user_favorites WHERE user_id = ? AND vacancy_id = ? AND vak = 1";
        } else {
            $sql = "INSERT INTO user_favorites (user_id, vacancy_id, vak) VALUES (?, ?, 1)";
        }

        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ii", $user_id, $vacancy_id);

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
        echo json_encode(["status" => "error", "message" => "Некоректний ідентифікатор вакансії."]);
    }
}

$conn->close();
?>
