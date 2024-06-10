<?php
$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$vacancy_id = $_POST['vacancy_id'];

$sql = "DELETE FROM vakancia WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $vacancy_id);

if ($stmt->execute()) {
    echo "Вакансія успішно видалена.";
} else {
    echo "Помилка при видаленні вакансії: " . $conn->error;
     header("Location: Адмін.php");
}

 header("Location: Адмін.php");
$stmt->close();
$conn->close();
?>
