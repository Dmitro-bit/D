<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $gmail = $_POST['gmail'];
    $password = $_POST['password'];

    $sql = "SELECT id_admin, password FROM admin WHERE name = ? AND surname = ? AND gmail = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die(json_encode(["status" => "error", "message" => "Помилка підготовки запиту: " . $conn->error]));
    }

    $stmt->bind_param("sss", $name, $surname, $gmail);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_admin, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['admin_id'] = $id_admin;
            echo json_encode(["status" => "success", "message" => "Login successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Неправильный пароль"]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Користувач не знайдений"]);
    }
    $stmt->close();
}

$conn->close();
?>
