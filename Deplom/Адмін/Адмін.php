<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id_admin = $_SESSION['admin_id'];

$stmt = $conn->prepare("SELECT name, surname FROM admin WHERE id_admin = ?");
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($name, $surname);
    $stmt->fetch();
} else {
    $name = "Unknown";
    $surname = "Unknown";
}

$vacancies = [];
$stmt = $conn->prepare("SELECT id, vid_zanatia, work, ot_praes, do_praes, oflaen, bez_dosvidy, sotrydnik, opus_vakansii, kr_pro_komp, vumogu, obov, umovu_rab, name, locatin FROM vakancia WHERE id_admin = ?");
$stmt->bind_param("i", $id_admin);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    $vacancies[] = $row;
}



$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="images/x-icon" href="../Фото/free-icon-vacancy.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
     <link rel="stylesheet" href="Адмін.css">
     <link rel="stylesheet" href="adept.css">
    <title>Роботодавець</title>



</head>
<body>

  <main>
  <div class="search-section">
    <div class="container1">
        <div class="logo">
            <a href="../Головна/Головна.php"><img src="../Фото/free-icon-vacancy.png" class="icone" alt="icone"><span class="logo-text">HotJob</span></a>
        </div>
    </div>

    <div class="container3">
        <div class="search-container">
            <form action="../Вакансії/Вакансії.php" method="GET">
                <div class="input-group">
                    <input type="text" name="search" id="search" class="pochykpole" placeholder="Ким або в якій компанії хочете працювати?">
                    <input type="submit" class="pochykknopka" value="Пошук">

                </div>
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
                    url: 'search.php',
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


<h1>Ласкаво просимо, <?php echo $name . " " . $surname; ?></h1>


<div class="tab-container">
        <div class="tabs">
            <button class="tablink" onclick="openTab(event, 'add')">Додати вакансію</button>
            <button class="tablink" onclick="openTab(event, 'view')">Переглянути вакансії</button>
            <button class="tablink" onclick="openTab(event, 'reactions')">Реакції користувачів</button>
            <button class="tablink" onclick="openTab(event, 'admin')">Профіль</button>
        </div>

        <div id="add" class="tabcontent">

    <form action="add_vacancy.php" method="post">



      <div>
        <div class="char-limit" id="charLimit">Залишилось символів: 50</div>
            <label for="work">Назва вакансії:</label>
            <input type="text" id="work" name="work" required maxlength="50" oninput="checkLength(this, 50, charLimit)">
            
        </div>

          <div>
            <div class="char-limit" id="charLimit1">Залишилось символів: 50</div>
            <label for="name">Назва компанії:</label>
            <input type="text" id="name" name="name" required maxlength="50" oninput="checkLength(this, 50, charLimit1)">
            
        </div>

<script>
 function checkLength(input, maxLength, output) {
            var remaining = maxLength - input.value.length;
            output.textContent = "Осталось символов: " + remaining;
            if (input.value.length > maxLength) {
                input.value = input.value.substring(0, maxLength);
            }
        }
    </script>


        <label for="vid_zanatia">Вид зайнятості:</label>
        <select name="vid_zanatia" id="vid_zanatia" required>
            <option value="1">Повна</option>
            <option value="2">Неповна</option>
            <option value="3">Позмінна</option>
        </select><br>

        

    
<label for="do_praes">Максимальна зарплата:</label>
<input type="text" id="do_praes" name="do_praes" min="0" pattern="[0-9]*" oninput="handleInput(this); updateMinPrice()" required><br>

<label for="ot_praes">Мінімальна зарплата:</label>
<input type="text" id="ot_praes" name="ot_praes" min="0" pattern="[0-9]*" oninput="handleInput(this); updateMaxPrice()" required><br>



 
        <label for="oflaen" class="checkbox-label">
            <input type="checkbox" id="oflaen" name="oflaen" class="checkbox-input">
            Дистанційна робота
        </label><br>

        <label for="bez_dosvidy" class="checkbox-label">
            <input type="checkbox" id="bez_dosvidy" name="bez_dosvidy" class="checkbox-input">
            Без досвіду
        </label><br>
   


        <label for="sotrydnik">Підходить для:</label>
        <select name="sotrydnik" id="sotrydnik" required>
            <option value="1">Для всіх</option>
            <option value="2">Студент</option>
            <option value="3">Люди з інвалідністю</option>
            <option value="4">Ветеранам</option>
            <option value="5">Пенсіонерам</option>
        </select><br>

        <div>
                <div class="char-limit" id="charLimit2">Залишилось символів: 255</div>
                <label for="opus_vakansii" class="input-label">Короткий опис вакансія:</label>
                <input type="text" id="opus_vakansii" name="opus_vakansii" required maxlength="255" oninput="checkLength(this, 255, charLimit2)" class="input-field"><br>
            </div>
            
            <div>
                <div class="char-limit" id="charLimit3">Залишилось символів: 100</div>
                <label for="kr_pro_komp" class="input-label">Короткий опис компанії:</label>
                <input type="text" id="kr_pro_komp" name="kr_pro_komp" required maxlength="100" oninput="checkLength(this, 100, charLimit3)" class="input-field"><br>
            </div>

            <div>
                <div class="char-limit" id="charLimit4">Залишилось символів: 255</div>
                <label for="vumogu" class="input-label">Вимоги:</label>
                <input type="text" id="vumogu" name="vumogu" required maxlength="255" oninput="checkLength(this, 255, charLimit4)" class="input-field"><br>
            </div>

            <div>
                <div class="char-limit" id="charLimit5">Залишилось символів: 255</div>
                <label for="obov" class="input-label">Обов'язки:</label>
                <input type="text" id="obov" name="obov" required maxlength="255" oninput="checkLength(this, 255, charLimit5)" class="input-field"><br>
            </div>

            <div>
                <div class="char-limit" id="charLimit6">Залишилось символів: 255</div>
                <label for="umovu_rab" class="input-label">Умови роботи:</label>
                <input type="text" id="umovu_rab" name="umovu_rab" required maxlength="255" oninput="checkLength(this, 255, charLimit6)" class="input-field"><br>
            </div>




       <label for="locatin">Розташування компанії:</label>
<select name="locatin" id="locatin" required>
    <option value="Будь-яка">Будь-яка</option>
    <option value="Вінницька">Вінницька</option>
    <option value="Волинська">Волинська</option>
    <option value="Дніпропетровська">Дніпропетровська</option>
    <option value="Донецька">Донецька</option>
    <option value="Житомирська">Житомирська</option>
    <option value="Закарпатська">Закарпатська</option>
    <option value="Запорізька">Запорізька</option>
    <option value="Івано-Франківська">Івано-Франківська</option>
    <option value="Київська">Київська</option>
    <option value="Кіровоградська">Кіровоградська</option>
    <option value="Луганська">Луганська</option>
    <option value="Львівська">Львівська</option>
    <option value="Миколаївська">Миколаївська</option>
    <option value="Одеська">Одеська</option>
    <option value="Полтавська">Полтавська</option>
    <option value="Рівненська">Рівненська</option>
    <option value="Сумська">Сумська</option>
    <option value="Тернопільська">Тернопільська</option>
    <option value="Харківська">Харківська</option>
    <option value="Херсонська">Херсонська</option>
    <option value="Хмельницька">Хмельницька</option>
    <option value="Черкаська">Черкаська</option>
    <option value="Чернівецька">Чернівецька</option>
    <option value="Чернігівська">Чернігівська</option>
</select><br>


        <input type="hidden" name="admin_id" value="<?php echo $_SESSION['admin_id']; ?>">

        <input type="submit" value="Додати вакансію">
    </form>




        </div>
<script>
function handleInput(input) {
    if (input.value.length > 1 && input.value.startsWith('0')) {
        input.value = input.value.substr(1); 
    }
    input.value = input.value.replace(/[^0-9]/g, ''); 
}


function updateMinPrice() {
    var maxPrice = parseInt(document.getElementById("do_praes").value);
    var minPriceInput = document.getElementById("ot_praes");
    var minPrice = parseInt(minPriceInput.value);

    if (minPrice >= maxPrice) {
        minPriceInput.value = maxPrice - 1000;
    }

    minPrice = parseInt(minPriceInput.value); 

    if (minPrice < 0) {
        minPriceInput.value = 0;
    }
}

function updateMaxPrice() {
    var minPrice = parseInt(document.getElementById("ot_praes").value);
    var maxPriceInput = document.getElementById("do_praes");
    var maxPrice = parseInt(maxPriceInput.value);

    if (minPrice >= maxPrice) {
        maxPriceInput.value = minPrice + 1000;
    }
}


        function checkLength(input, maxLength, output) {
            var remaining = maxLength - input.value.length;
            output.textContent = "Залишилось символів: " + remaining;
            if (input.value.length > maxLength) {
                input.value = input.value.substring(0, maxLength);
            }
        }
    

</script>






         <div id="view" class="tabcontent">
      
        <div class="admin-info">
      






        
    </div>

<div class="vacancies">
    <h2>Вакансії адміністратора</h2>
    <?php if (count($vacancies) > 0): ?>
        <?php foreach ($vacancies as $vacancy): ?>
            <div class="vacancy">

                <h3>Назва вакансії: <?php echo htmlspecialchars($vacancy['work']); ?></h3>
                <p>Назва компанії: <?php echo htmlspecialchars($vacancy['name']); ?></p>
                <p>Вид зайнятості: 
                    <?php 
                    switch ($vacancy['vid_zanatia']) {
                        case 1: echo "Повна"; break;
                        case 2: echo "Неповна"; break;
                        case 3: echo "Позмінна"; break;
                        default: echo "Невідомо";
                    }
                    ?>
                </p>
                <p>Мінімальна зарплата: <?php echo $vacancy['ot_praes'] == 0 ? "Будь-яка" : htmlspecialchars($vacancy['ot_praes']); ?></p>
                <p>Максимальна зарплата: <?php echo $vacancy['do_praes'] == 0 ? "Будь-яка" : htmlspecialchars($vacancy['do_praes']); ?></p>
                <p>Дистанційна робота: <?php echo $vacancy['oflaen'] ? "Так" : "Ні"; ?></p>
                <p>Без досвіду: <?php echo $vacancy['bez_dosvidy'] ? "Так" : "Ні"; ?></p>
                <p>Підходить для: 
                    <?php 
                    switch ($vacancy['sotrydnik']) {
                        case 1: echo "Для всіх"; break;
                        case 2: echo "Студент"; break;
                        case 3: echo "Люди з інвалідністю"; break;
                        case 4: echo "Ветеранам"; break;
                        case 5: echo "Пенсіонерам"; break;
                        default: echo "Невідомо";
                    }
                    ?>
                </p>
                <p>Короткий опис вакансії: <?php echo htmlspecialchars($vacancy['opus_vakansii']); ?></p>
                <p>Опис компанії: <?php echo htmlspecialchars($vacancy['kr_pro_komp']); ?></p>
                <p>Вимоги: <?php echo htmlspecialchars($vacancy['vumogu']); ?></p>
                <p>Обов'язки: <?php echo htmlspecialchars($vacancy['obov']); ?></p>
                <p>Умови роботи: <?php echo htmlspecialchars($vacancy['umovu_rab']); ?></p>
                <p>Розташування компанії: <?php echo htmlspecialchars($vacancy['locatin']); ?></p>
                <form action="edit_vacancy.php" method="post">
                    <input type="hidden" name="admin_id" value="<?php echo $vacancy['id']; ?>">
                    <input type="submit" value="Редагувати">
                </form>
                <form action="delete_vacancy.php" method="post">
    <input type="hidden" name="vacancy_id" value="<?php echo $vacancy['id']; ?>">
    <input type="submit" value="Видалити" onclick="return confirm('Бажаєте видалити вакансію?');">
</form>

            </div>
            <hr>
        <?php endforeach; ?>
    <?php else: ?>
        <p>У вас поки що немає вакансій.</p>
    <?php endif; ?>
</div>











    </div>

        <div id="reactions" class="tabcontent">
       <section class="partners">
        <div class="container">
            <h2>Відмічені вакансії</h2>
            <div class="vacancies">
<?php
session_start();

$conn = new mysqli('localhost', 'root', '', 'rab');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT v.id, v.work, v.opus_vakansii, COUNT(uf.id) as favorite_count, v.id_admin
        FROM vakancia v
        LEFT JOIN user_favorites uf ON v.id = uf.vacancy_id
        WHERE uf.vak IS NOT NULL AND EXISTS (SELECT 1 FROM user_favorites uf2 WHERE uf2.vacancy_id = v.id AND uf2.vak IS NOT NULL AND v.id_admin = " . $_SESSION['admin_id'] . ")
        GROUP BY v.id, v.work, v.opus_vakansii, v.id_admin
        ORDER BY favorite_count DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<div class="vacancy" data-vacancy-id="' . $row["id"] . '">';
        echo '<a href="../Опис вакансії/vacancy_detail.php?id=' . $row["id"] . '">';
        echo '<h3>' . $row["work"] . '</h3>';
        echo '<p>' . $row["opus_vakansii"] . '</p>';
        echo '</a>';

        $user_sql = "SELECT u.id_user, u.name, u.surname, u.fone, u.gmail, u.rezyme, uf.per
                     FROM user u
                     JOIN user_favorites uf ON u.id_user = uf.user_id
                     WHERE uf.vacancy_id = " . $row["id"] . " AND uf.vak IS NOT NULL";
        $user_result = $conn->query($user_sql);

        if ($user_result->num_rows > 0) {
            echo '<div class="user-info">';
            echo '<h4>Користувачі, які відмітили цю вакансію:</h4>';
            echo '<ul class="user-list" data-vacancy-id="' . $row["id"] . '">';
            while ($user_row = $user_result->fetch_assoc()) {
                $perMarked = $user_row["per"] == 1 ? 'marked' : '';
                echo '<li class="user-entry ' . $perMarked . '">' . $user_row["name"] . ' ' . $user_row["surname"] . ' | Телефон: ' . $user_row["fone"] . ' | Email: ' . $user_row["gmail"] . '<br>';
                echo '<img src="data:image/jpeg;base64,' . base64_encode($user_row["rezyme"]) . '" alt="Резюме ' . $user_row["name"] . ' ' . $user_row["surname"] . '" "><br>';
                echo '<button class="reject-button"  data-vacancy-id="' . $row["id"] . '" data-user-id="' . $user_row["id_user"] . '">Відмовити</button>';
                echo '<button class="mark-button" data-vacancy-id="' . $row["id"] . '" data-user-id="' . $user_row["id_user"] . '">' . ($user_row["per"] == 1 ? 'Зв`язатися' : 'Обрати?') . '</button>';
                echo '</li>';
            }
            echo '</ul>';
            echo '</div>';
        } else {
            echo '<p class="user-info">Відгуки закінчилися від користувачів.</p>';
        }

        echo '</div>';
    }
} else {
    echo "Популярних вакансій не знайдено.";
}

$conn->close();
?>

<script>
document.addEventListener('DOMContentLoaded', (event) => {
    document.querySelectorAll('.reject-button').forEach(button => {
        button.addEventListener('click', function() {
            const vacancyId = this.getAttribute('data-vacancy-id');
            const userId = this.getAttribute('data-user-id');
            const userElement = this.closest('.user-entry');

            fetch('reject_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ vacancy_id: vacancyId, user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert('Користувача відхилено успішно');
                    userElement.remove();
                    const userList = document.querySelector(`.user-list[data-vacancy-id="${vacancyId}"]`);
                    if (userList.children.length === 0) {
                        const vacancyElement = document.querySelector(`.vacancy[data-vacancy-id="${vacancyId}"]`);
                        vacancyElement.querySelector('.user-info').innerHTML = '<p>Відгуки закінчилися від користувачів.</p>';
                    }
                } else {
                    alert('Помилка: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });

    document.querySelectorAll('.mark-button').forEach(button => {
        button.addEventListener('click', function() {
            const vacancyId = this.getAttribute('data-vacancy-id');
            const userId = this.getAttribute('data-user-id');
            const userElement = this.closest('.user-entry');

            fetch('approve_user.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ vacancy_id: vacancyId, user_id: userId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    userElement.classList.toggle('marked');
                    button.textContent = userElement.classList.contains('marked') ? 'Зв`язатися' : 'Обрати?';
                } else {
                    alert('Помилка: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
    });
});
</script>



</div>
        </div>
    </section>
        </div>



        <div id="admin" class="tabcontent">
<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: login_admin.html");
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'rab');
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$admin_id = $_SESSION['admin_id'];

$sql = "SELECT * FROM admin WHERE id_admin=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $admin_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
}
$stmt->close();
$conn->close();
?>



    <?php
    if (isset($_GET['success'])) {
        echo "<p>Дані успішно оновлені.</p>";
    }
    if (isset($_GET['error'])) {
        echo "<p>Помилка: " . htmlspecialchars($_GET['error']) . "</p>";
    }
    ?>

    <form method="POST" action="process_admin.php" class="admin-form" onsubmit="return validateForm();">
        <h2>Редагувати інформацію</h2>
        <label for="name">Ім'я:</label>
        <input type="text" maxlength="25" id="name" name="name" value="<?php echo htmlspecialchars($admin['name']); ?>" oninput="validateText(this)" required>

        <label for="surname">Прізвище:</label>
        <input type="text" id="surname" maxlength="25" name="surname" value="<?php echo htmlspecialchars($admin['surname']); ?>" oninput="validateText(this)" required>

        <label for="gmail">Електронна пошта:</label>
        <input type="email" id="gmail" maxlength="50" name="gmail" value="<?php echo htmlspecialchars($admin['gmail']); ?>" required>

        <label for="password">Новий пароль (залиште пустим, якщо не хочете змінювати):</label>
        <input type="password" id="password" name="password" oninput="validatePassword(this)">
        <div id="passwordError" style="color: red;"></div>

        <button type="submit" name="update">Оновити дані</button>
    </form>

    <form method="POST" action="process_admin.php" class="delete-profile-form" onsubmit="return confirmDeletion();">
        <button type="submit" name="delete_profile">Видалити профіль</button>
    </form>

    <script>
        function validateText(input) {
            input.value = input.value.replace(/[^a-zA-Zа-яА-ЯєЄіІїЇґҐ\s-]/g, '');
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

        function confirmDeletion() {
            return confirm("Бажаєте видалити профіль? Разом з профілем також видаляться і вакансії цього профілю.");
        }
    </script>











    </div>

</div>

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

         document.getElementById('admin').classList.add('active');
    </script>

 
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

</body>

</html>
