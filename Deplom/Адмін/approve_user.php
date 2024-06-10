<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    echo json_encode(["status" => "error", "message" => "Будьласка, увійдіть або зареєструйтесь."]);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input = json_decode(file_get_contents('php://input'), true);
    $vacancy_id = isset($input['vacancy_id']) ? intval($input['vacancy_id']) : 0;
    $user_id = isset($input['user_id']) ? intval($input['user_id']) : 0;

    if ($vacancy_id > 0 && $user_id > 0) {
        $sql_check = "SELECT per FROM user_favorites WHERE user_id = ? AND vacancy_id = ?";
        $stmt_check = $conn->prepare($sql_check);
        $stmt_check->bind_param("ii", $user_id, $vacancy_id);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        
        if ($result_check->num_rows > 0) {
            $row = $result_check->fetch_assoc();
            if ($row['per'] == 1) {
                $sql_update = "UPDATE user_favorites SET per = NULL WHERE user_id = ? AND vacancy_id = ?";
            } else {
                $sql_update = "UPDATE user_favorites SET per = 1 WHERE user_id = ? AND vacancy_id = ?";
            }
        } else {
            $sql_update = "INSERT INTO user_favorites (user_id, vacancy_id, per) VALUES (?, ?, 1)";
        }
        
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("ii", $user_id, $vacancy_id);
        
        if ($stmt_update->execute()) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Помилка виконання запита: " . $stmt_update->error]);
        }

        $stmt_check->close();
        $stmt_update->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Некоректний ідентифікатор вакансії або користувача."]);
    }
}

$conn->close();
?>
