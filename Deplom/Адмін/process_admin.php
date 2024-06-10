<?php
session_start();
ob_start();

$conn = new mysqli('localhost', 'root', '', 'rab');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.html");
    exit();
}

$admin_id = $_SESSION['admin_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $name = $conn->real_escape_string($_POST['name']);
    $surname = $conn->real_escape_string($_POST['surname']);
    $gmail = $conn->real_escape_string($_POST['gmail']);
    
    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $update_sql = "UPDATE admin SET name=?, surname=?, gmail=?, password=? WHERE id_admin=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("ssssi", $name, $surname, $gmail, $password, $admin_id);
    } else {
        $update_sql = "UPDATE admin SET name=?, surname=?, gmail=? WHERE id_admin=?";
        $stmt = $conn->prepare($update_sql);
        $stmt->bind_param("sssi", $name, $surname, $gmail, $admin_id);
    }

    if ($stmt->execute()) {
        header("Location: Адмін.php?success=update");
        exit();
    } else {
        header("Location: Адмін.php?error=update");
        exit();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_profile'])) {
    $conn->autocommit(FALSE); 

    try {
        $delete_vacancies_sql = "DELETE FROM vakancia WHERE id_admin = ?";
        $stmt = $conn->prepare($delete_vacancies_sql);
        $stmt->bind_param("i", $admin_id);
        if (!$stmt->execute()) {
            throw new Exception("Помилка при видаленні вакансій: " . $stmt->error);
        }
        $stmt->close();

        $delete_admin_sql = "DELETE FROM admin WHERE id_admin = ?";
        $stmt = $conn->prepare($delete_admin_sql);
        $stmt->bind_param("i", $admin_id);
        if (!$stmt->execute()) {
            throw new Exception("Помилка при видаленні профілю адміністратора: " . $stmt->error);
        }
        $stmt->close();

        if (!$conn->commit()) {
            throw new Exception("Помилка при виконанні транзакції: " . $conn->error);
        }

        session_destroy();
        header("Location: ../Головна/Головна.php");
        exit();

    } catch (Exception $e) {
        $conn->rollback();
        header("Location: Адмін.php?error=" . urlencode($e->getMessage()));
        exit();
    }
}
?>
