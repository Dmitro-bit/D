<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $fone = trim($_POST['fone']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM `user` WHERE `name`=? AND `surname`=? AND `fone`=?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        echo json_encode(["status" => "error", "message" => "Помилка при підготовці запиту: " . $conn->error]);
        exit();
    }

    $stmt->bind_param("sss", $name, $surname, $fone);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_surname'] = $user['surname'];
            $_SESSION['user_id'] = $user['id_user'];
            echo json_encode(["status" => "success", "message" => "Вхід успішний"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Невірний пароль"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Користувача не знайдено"]);
    }

    $stmt->close();
}

$conn->close();
?>
