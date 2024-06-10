<?php
session_start();

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: ../Головна/Головна.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_user'])) {
    session_start();
    try {
        $id_user = intval($_POST['id_user']);
        $name = $conn->real_escape_string($_POST['name']);
        $surname = $conn->real_escape_string($_POST['surname']);
        $fone = $conn->real_escape_string($_POST['fone']);
        $gmail = $conn->real_escape_string($_POST['gmail']);
        $password = isset($_POST['password']) ? $_POST['password'] : '';

        $sql = "UPDATE user SET name=?, surname=?, fone=?, gmail=?";
        $params = [$name, $surname, $fone, $gmail];
        $types = "ssss";

        if (!empty($password)) {
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            $sql .= ", password=?";
            $params[] = $hashed_password;
            $types .= "s";
        }

        if (isset($_FILES['rezyme']) && $_FILES['rezyme']['error'] === UPLOAD_ERR_OK) {
            $fileTmpPath = $_FILES['rezyme']['tmp_name'];
            $fileData = file_get_contents($fileTmpPath);
            $fileSize = $_FILES['rezyme']['size'];

            if ($fileSize > 5 * 1024 * 1024) {
                $_SESSION['message'] = "Розмір файлу перевищує допустимий ліміт";
                $_SESSION['message_type'] = "error";
                header("Location: {$_SERVER['PHP_SELF']}");
                exit();
            }

            $sql .= ", rezyme=?";
            $params[] = $fileData;
            $types .= "b";
        }

        $sql .= " WHERE id_user=?";
        $params[] = $id_user;
        $types .= "i";

        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            error_log("Помилка підготовки запиту: " . $conn->error);
            throw new Exception("Внутрішня помилка сервера. Спробуйте пізніше.");
        }

        $stmt->bind_param($types, ...$params);

        if (isset($fileData)) {
            $stmt->send_long_data(array_search($fileData, $params), $fileData);
        }

        if ($stmt->execute() === TRUE) {
            $_SESSION['message'] = "Дані користувача успішно оновлені.";
            $_SESSION['message_type'] = "success";
            if (isset($fileData)) {
                $_SESSION['updated_image'] = base64_encode($fileData);
            }
        } else {
            error_log("Помилка виконання запиту: " . $stmt->error);
            throw new Exception("Виникла помилка при оновленні запису.");
        }

        $stmt->close();
    } catch (Exception $e) {
        $_SESSION['message'] = $e->getMessage();
        $_SESSION['message_type'] = "error";
    }

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}



if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_account'])) {
    $id_user = intval($_POST['user_id']);
    $sql = "DELETE FROM user WHERE id_user=$id_user";

    if ($conn->query($sql) === TRUE) {
        session_unset();
        session_destroy();
        header("Location: ../Головна/Головна.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}


if (!isset($_SESSION['user_id'])) {
    echo "User is not logged in.";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM `user` WHERE `id_user` = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$sql_vak = "SELECT v.* FROM `vakancia` v
            JOIN `user_favorites` uf ON v.id = uf.vacancy_id
            WHERE uf.user_id = $user_id AND uf.vak = 1";
$result_vak = $conn->query($sql_vak);
$vak_data = [];
if ($result_vak->num_rows > 0) {
    while ($row = $result_vak->fetch_assoc()) {
        $vak_data[] = $row;
    }
}

$sql_otmeti = "SELECT v.* FROM `vakancia` v
               JOIN `user_favorites` uf ON v.id = uf.vacancy_id
               WHERE uf.user_id = $user_id AND uf.otmeti = 1";
$result_otmeti = $conn->query($sql_otmeti);
$otmeti_data = [];
if ($result_otmeti->num_rows > 0) {
    while ($row = $result_otmeti->fetch_assoc()) {
        $otmeti_data[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="images/x-icon" href="../Фото/free-icon-vacancy.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="functioт.js"></script>
    <link rel="stylesheet" href="user_info1.css">
    <link rel="stylesheet" href="adept.css">
    <title>Шукач</title>
</head>
<body>

      <div class="search-section">
    <div class="container1">

         <div class="logo">
        <a href="../Головна/Головна.php"><img src="../Фото/free-icon-vacancy.png" class="icone" alt="icone"><span class="logo-text">HotJob</span></a>
    </div>

       
    </div>

    <div class="container3">
        <div class="search-container">
            <form action="../Вакансії/Вакансії.php" method="GET">
                <input type="text" name="search" id="search" class="pochykpole" placeholder="Ким або в якій компанії хочете працювати?">
                <input type="submit" class="pochykknopka" value="Пошук">
                <div class="search-results"></div>
            </form>
            
        </div>
    </div>
</div>



<script>
    $(document).ready(function(){
        $('#search').on('input', function(){
            var query = $(this).val();
            if(query !== ''){
                $.ajax({
                    url: '../Пошук/search.php',
                    method: 'POST',
                    data: {search: query},
                    success: function(data){
                        $('.search-results').html(data);
                    }
                });
            } else {
                $('.search-results').html('');
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var searchSection = document.querySelector('.search-section');
        var lastScrollTop = 0;
        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            if (scrollTop > lastScrollTop) {
                searchSection.style.top = '-200px';
            } else {
                searchSection.style.top = '0';
            }
            lastScrollTop = scrollTop;
        });
    });

    
</script>



<div class="tab-container">
    <div class="tabs">
        <button class="tablink" onclick="openTab(event, 'add')">Інформація про користувача</button>
        <button class="tablink" onclick="openTab(event, 'view')">Обрані вакансії</button>
        <button class="tablink" onclick="openTab(event, 'reactions')">Переглянути які сподобалися</button>
    </div>

     <div id="add" class="tabcontent">
     <h1>Інформація про користувача</h1>
<form id="updateForm" class="user-form" method="post" action="" enctype="multipart/form-data">
    <input type="hidden" name="id_user" value="<?php echo htmlspecialchars($user['id_user']); ?>">
    <p>
        Ім'я: <input type="text" maxlength="25" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" oninput="validateText(this)">
    </p>
    <p>
        Прізвище: <input type="text" maxlength="25" name="surname" value="<?php echo htmlspecialchars($user['surname']); ?>" oninput="validateText(this)">
    </p>
    <p>
        Телефон: <input type="text" maxlength="12" name="fone" value="<?php echo htmlspecialchars($user['fone']); ?>" oninput="validatePhone(this)">
    </p>
    <p>
        Електронна пошта: <input type="text" maxlength="50" name="gmail" value="<?php echo htmlspecialchars($user['gmail']); ?>">
    </p>
    <p>
        Новий пароль (залиште пустим, якщо не хочете змінювати): <input type="password" id="password" name="password" minlength="4" oninput="validatePassword(this)">
        <div id="passwordError" class="error"></div>
    </p>
   
<p>
    Зображення резюме: <input class="inputfile" type="file" id="file" data-multiption="{count} файлов обрано" name="rezyme" accept="image/*">
    <label for="file">Оберіть фото</label>
</p>
<p>
    <img src="data:image/jpeg;base64,<?php echo base64_encode($user['rezyme']); ?>" alt="Резюме" style="max-width: 90%;">
</p>




    <button type="submit" name="update_user">Оновити</button>

    <div id="responseMessage"></div>
</form>
<form id="deleteForm" class="aut" method="post" action="" onsubmit="return confirmDelete()">
    <input type="hidden" name="user_id" value="<?php echo $user['id_user']; ?>">
    <button type="submit" name="delete_account" onclick="return confirm('Бажаєте видалити вакансію?');">Видалити акаунт</button>
    <a href="?logout=true"><button type="button" >Вийти</button></a>
</form>
<div id="message" class="message"></div>
<script>
function ready {}
{
    var inputs = document.querySelectorAll('inputfile');
    Array.prototype.forEach.call(inputs, function( input)
    {
        var label = input.nextElementSibling,
        labelVal = label.innerHTML;

        input.addEventListener( 'change', function( e )
        {
console.log(this.files);
var fileName='';
if( this.files && this.files.length > 1)
    fileName = (this.getAttribute('data-multiple-caption') || '' ).replace('{count}', this.length)
else {
    fileName = this.files[0].name;

    if( fileName )
        label.querySelector('span').innerHTML = fileName;
    else 
    label.innerHTML = labelVal;
}
        });
    });
};

document.addEventListener("DOMContentLoaded", ready);


function validateText(input) {
    input.value = input.value.replace(/[^a-zA-Zа-яА-ЯєЄіІїЇґҐ\s-]/g, '');
}

function validatePhone(input) {
    input.value = input.value.replace(/[^0-9]/g, '');
}



function validatePassword(input) {
    var errorDiv = document.getElementById("passwordError");
    var regex = /^(?=.*[A-Za-z]).{4,}$/;
    if (!regex.test(input.value)) {
        errorDiv.textContent = "Пароль має бути мінімум 4 символи і містити хоча б одну латинську літеру.";
    } else {
        errorDiv.textContent = "";
    }
}

document.addEventListener("DOMContentLoaded", function() {
    <?php if (isset($_SESSION['message'])): ?>
        var message = "<?php echo $_SESSION['message']; ?>";
        var messageType = "<?php echo $_SESSION['message_type']; ?>";

        if (messageType === "success") {
            alert(message); 
        } else if (messageType === "error") {
            alert(message); 
        }

        <?php if (isset($_SESSION['updated_image'])): ?>
            var imgElement = document.querySelector('img[alt="Резюме"]');
            imgElement.src = 'data:image/jpeg;base64,' + "<?php echo $_SESSION['updated_image']; ?>";
        <?php unset($_SESSION['updated_image']); endif; ?>

   
        <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
    <?php endif; ?>



</script>







    </div>

    <div id="view" class="tabcontent">
        <h1>Вакансії</h1>
<?php
session_start();


$user_id = $_SESSION['user_id'];

$conn = new mysqli('localhost', 'root', '', 'rab');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!empty($vak_data)) {
    foreach ($vak_data as $vak) {
        echo "<h2>" . htmlspecialchars($vak['work']) . "</h2>";
        echo "<p>Назва компанії: " . htmlspecialchars($vak['name']) . "</p>";
        echo "<p>Вид зайнятості: ";
        switch ($vak['vid_zanatia']) {
            case 1: echo "Повна"; break;
            case 2: echo "Неповна"; break;
            case 3: echo "Позмінна"; break;
            default: echo "Невідомо";
        }
        echo "</p>";
        echo "<p>Мінімальна зарплата: " . htmlspecialchars($vak['ot_praes']) . "</p>";
        echo "<p>Максимальная зарплата: " . htmlspecialchars($vak['do_praes']) . "</p>";
        echo "<p>Офлайн: " . ($vak['oflaen'] ? "Так" : "Ні") . "</p>";
        echo "<p>Без досвіду: " . ($vak['bez_dosvidy'] ? "Так" : "Ні") . "</p>";
        echo "<p>Співробітник: ";
        switch ($vak['sotrydnik']) {
            case 1: echo "Для всіх"; break;
            case 2: echo "Студент"; break;
            case 3: echo "Люди з інвалідністю"; break;
            case 4: echo "Ветеранам"; break;
            case 5: echo "Пенсіонерам"; break;
            default: echo "Невідомо";
        }
        echo "</p>";
        echo "<p>Опис вакансії: " . htmlspecialchars($vak['opus_vakansii']) . "</p>";
        echo "<p>Опис компанії: " . htmlspecialchars($vak['kr_pro_komp']) . "</p>";
        echo "<p>Вимоги: " . htmlspecialchars($vak['vumogu']) . "</p>";
        echo "<p>Обов'язки: " . htmlspecialchars($vak['obov']) . "</p>";
        echo "<p>Умови роботи: " . htmlspecialchars($vak['umovu_rab']) . "</p>";
        echo "<p>Розташування компанії: " . htmlspecialchars($vak['locatin']) . "</p>";

        $check_sql = "SELECT per FROM user_favorites WHERE user_id = ? AND vacancy_id = ?";
        $stmt = $conn->prepare($check_sql);
        $stmt->bind_param("ii", $user_id, $vak['id']);
        $stmt->execute();
        $stmt->bind_result($per);
        $stmt->fetch();
        $stmt->close();

        if ($per == 1) {
            echo "<p style='color: green; font-weight: bold;'>Ваша заявка на роботу розглянута, очікуйте з вами скоро зв'яжуться!</p>";
        }
    }
} else {
    echo "<p>Вакансії не обрано.</p>";
}

$conn->close();
?>


    </div>

    <div id="reactions" class="tabcontent">
        <h1>Вакансії, які сподобалися</h1>
<?php
if (!empty($otmeti_data)) {
    foreach ($otmeti_data as $otmeti) {
        echo "<h2>" . htmlspecialchars($otmeti['work']) . "</h2>";
        echo "<p>Назва компанії: " . htmlspecialchars($otmeti['name']) . "</p>";

        echo "<p>Вид зайнятості: ";
        switch ($otmeti['vid_zanatia']) {
            case 1: echo "Повна"; break;
            case 2: echo "Неповна"; break;
            case 3: echo "Позмінна"; break;
            default: echo "Невідомо";
        }
        echo "</p>";
        echo "<p>Мінімальна зарплата: " . htmlspecialchars($otmeti['ot_praes']) . "</p>";
        echo "<p>Максимальная зарплата: " . htmlspecialchars($otmeti['do_praes']) . "</p>";
        echo "<p>Офлайн: " . ($otmeti['oflaen'] ? "Так" : "Ні") . "</p>";
        echo "<p>Без досвіду: " . ($otmeti['bez_dosvidy'] ? "Так" : "НІ") . "</p>";
        echo "<p>Співробітник: ";
        switch ($otmeti['sotrydnik']) {
            case 1: echo "Для всіх"; break;
            case 2: echo "Студент"; break;
            case 3: echo "Люди з інвалідністю"; break;
            case 4: echo "Ветеранам"; break;
            case 5: echo "Пенсіонерам"; break;
            default: echo "Невідомо";
        }
        echo "</p>";
        echo "<p>Опис вакансії: " . htmlspecialchars($otmeti['opus_vakansii']) . "</p>";
        echo "<p>Опис компанії: " . htmlspecialchars($otmeti['kr_pro_komp']) . "</p>";
        echo "<p>Вимоги: " . htmlspecialchars($otmeti['vumogu']) . "</p>";
        echo "<p>Обов'язки: " . htmlspecialchars($otmeti['obov']) . "</p>";
        echo "<p>Умови роботи: " . htmlspecialchars($otmeti['umovu_rab']) . "</p>";
        echo "<p>Розташування компанії: " . htmlspecialchars($otmeti['locatin']) . "</p>";
    }
} else {
    echo "<p>Вакансії не обрано.</p>";
}
?>

    </div>
</div>


<footer>
    <div class="footer-container">
        <div class="footer-section about">
            <h2>Про нас</h2>
            <p>Ми компанія, що надає найкращі вакансії для шукачів та якісних співробітників для роботодавців.</p>
        </div>
 
        <div class="footer-section contact">
            <h2>Контакти</h2>
            <p>Email: 195student@mksumdu.info</p>
            <p>Телефон: +873 456 7890</p>
        </div>
        <div class="footer-section social">
            <h2>Ми у соціальних мережах</h2>
            <div class="social-links">
                <a href="#"><img src="../Фото/Facebook.png" alt="Facebook"></a>
                <a href="#"><img src="../Фото/Telegram.png" alt="Telegram"></a>
                <a href="#"><img src="../Фото/Instagram.png" alt="Instagram"></a>
            </div>
        </div>
    </div>

</div>
</footer>


<script>
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablink");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }

    document.getElementsByClassName("tablink")[0].click();
</script>
</body>
</html>
