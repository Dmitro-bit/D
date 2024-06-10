<?php
$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$vid_zanatia = $_POST['vid_zanatia'];
$work = $_POST['work'];
$ot_praes = $_POST['ot_praes'];
$do_praes = $_POST['do_praes'];
$oflaen = isset($_POST['oflaen']) ? 1 : 0;
$bez_dosvidy = isset($_POST['bez_dosvidy']) ? 1 : 0;
$sotrydnik = $_POST['sotrydnik'];
$opus_vakansii = $_POST['opus_vakansii'];
$kr_pro_komp = $_POST['kr_pro_komp'];
$vumogu = $_POST['vumogu'];
$obov = $_POST['obov'];
$umovu_rab = $_POST['umovu_rab'];
$name = $_POST['name'];
$locatin = $_POST['locatin'];
$id_admin = $_POST['admin_id']; 

try {
    $stmt = $conn->prepare("INSERT INTO vakancia (id_admin, vid_zanatia, work, ot_praes, do_praes, oflaen, bez_dosvidy, sotrydnik, opus_vakansii, kr_pro_komp, vumogu, obov, umovu_rab, name, locatin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        throw new Exception("Помилка підготовки запиту: " . $conn->error);
    }

    $stmt->bind_param("iisiiiiisssssss", $id_admin, $vid_zanatia, $work, $ot_praes, $do_praes, $oflaen, $bez_dosvidy, $sotrydnik, $opus_vakansii, $kr_pro_komp, $vumogu, $obov, $umovu_rab, $name, $locatin);

    if (!$stmt->execute()) {
        throw new Exception("Помилка виконання запиту: " . $stmt->error);
    }

    $stmt->close();
    echo "Вакансія успішно додана!";
} catch (Exception $e) {
    error_log("Помилка: " . $e->getMessage());
    echo "Помилка: " . $e->getMessage();
}

$conn->close();
header("Location: Адмін.php");
?>
