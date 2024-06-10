<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = new mysqli("localhost", "root", "", "rab");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = (int)$_POST['id'];
    $work = htmlspecialchars($_POST['work'], ENT_QUOTES, 'UTF-8');
    $name = htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');
    $vid_zanatia = (int)$_POST['vid_zanatia'];
    $ot_praes = (int)$_POST['ot_praes'];
    $do_praes = (int)$_POST['do_praes'];
    $oflaen = isset($_POST['oflaen']) ? 1 : 0; 
    $bez_dosvidy = isset($_POST['bez_dosvidy']) ? 1 : 0; 
    $sotrydnik = (int)$_POST['sotrydnik'];
    $opus_vakansii = htmlspecialchars($_POST['opus_vakansii'], ENT_QUOTES, 'UTF-8');
    $kr_pro_komp = htmlspecialchars($_POST['kr_pro_komp'], ENT_QUOTES, 'UTF-8');
    $vumogu = htmlspecialchars($_POST['vumogu'], ENT_QUOTES, 'UTF-8');
    $obov = htmlspecialchars($_POST['obov'], ENT_QUOTES, 'UTF-8');
    $umovu_rab = htmlspecialchars($_POST['umovu_rab'], ENT_QUOTES, 'UTF-8');
    $locatin = htmlspecialchars($_POST['locatin'], ENT_QUOTES, 'UTF-8');

    $query = "UPDATE vakancia SET work=?, name=?, vid_zanatia=?, ot_praes=?, do_praes=?, oflaen=?, bez_dosvidy=?, sotrydnik=?, opus_vakansii=?, kr_pro_komp=?, vumogu=?, obov=?, umovu_rab=?, locatin=? WHERE id=?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Помилка підготовки запиту: " . $conn->error);
    }

    $stmt->bind_param("ssiiiiiissssssi", $work, $name, $vid_zanatia, $ot_praes, $do_praes, $oflaen, $bez_dosvidy, $sotrydnik, $opus_vakansii, $kr_pro_komp, $vumogu, $obov, $umovu_rab, $locatin, $id);

    if ($stmt->execute()) {
        header("Location: Адмін.php");
        exit();
    } else {
        echo "Помилка підготовки запиту: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    header("Location: edit_vacancy.php");
    exit();
}
?>
