<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вакансії</title>
    <link rel="stylesheet" href="Вакансії.css">
    <link rel="stylesheet" href="adept.css">
    <link rel="icon" type="images/x-icon" href="../Фото/free-icon-vacancy.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <main>
  <div class="search-section">
    <div class="container1">

         <div class="logo">
        <a href="../Головна/Головна.php"><img src="../Фото/free-icon-vacancy.png" class="icone" alt="icone"><span class="logo-text">HotJob</span></a>
    </div>

        <div class="auth-buttons">
            <?php
            session_start();
            if (isset($_SESSION['user_name']) && isset($_SESSION['user_surname']) && isset($_SESSION['user_id'])) {
                echo '<a href="../Шукач/user_info.php?user_id=' . $_SESSION['user_id'] . '">' . $_SESSION['user_name'] . ' ' . $_SESSION['user_surname'] . '</a>';
            } else {
                echo '<button id="loginButton">Увійти</button>';
                echo '<button id="registerButton">Зареєструватися</button>';
            }
            ?>
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

    function openAuthWindow(action) {
        if (action === 'login') {
            link = "../Шукач/login_user1.html";
        } else if (action === 'register') {
            link = "../Шукач/zar_user.html";
        }
        window.location.href = link;
    }

    document.getElementById('loginButton').addEventListener('click', function() {
        openAuthWindow('login');
    });

    document.getElementById('registerButton').addEventListener('click', function() {
        openAuthWindow('register');
    });
</script>



      <section class="recruiting">
    <div class="container2">
        <div class="filters">
            <form id="filterForm" method="GET">
                <label for="vid_zanatia">Вид занятости:</label>
                <select name="vid_zanatia" id="vid_zanatia">
                    <option value="">Будь-яка</option>
                    <option value="1">Повна</option>
                    <option value="2">Неповна</option>
                    <option value="3">Позмінна</option>
                </select>
                
                <label for="ot_praes">Мінімальна ціна:</label>
                <select name="ot_praes" id="ot_praes">
                    <option value="">Будь-яка</option>
                    <option value="1000">1000</option>
                    <option value="3000">3000</option>
                    <option value="5000">5000</option>
                    <option value="8000">8000</option>
                </select>

                <label for="do_praes">Максимальна ціна:</label>
                <select name="do_praes" id="do_praes">
                    <option value="">Будь-яка</option>
                    <option value="10000">10000</option>
                    <option value="20000">20000</option>
                    <option value="30000">30000</option>
                    <option value="50000">50000</option>
                </select>

                <label for="sotrydnik">Підходить для:</label>
                <select name="sotrydnik" id="sotrydnik">
                    <option value="">Для всіх</option>
                    <option value="2">Студент</option>
                    <option value="3">Люди з інвалідністю</option>
                    <option value="4">Ветеранам</option>
                    <option value="5">Пенсіонерам</option>
                </select>

                <label for="regionSelect">Оберіть область:</label>
                <select id="regionSelect" name="regionSelect" class="pochykpole">
                    <option value="">Будь-яка</option>
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
                </select>

                <label><input type="checkbox" name="oflaen" id="oflaen" value="1"> Віддалена робота</label>
                <label><input type="checkbox" name="bez_dosvidy" id="bez_dosvidy" value="1"> Без досвіду</label>

                <button type="reset" id="resetButton">Очистити все</button>
                <button type="submit">Застосувати фільтри</button>
            </form>
        </div>
    </div>
</section>


        <section class="vacancies">
            <div class="container">
                <h2>Список вакансій</h2>
                <div class="vacancy-list">
                      <?php
                $conn = new mysqli("localhost", "root", "", "rab");

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $search = isset($_GET['search']) ? $conn->real_escape_string($_GET['search']) : '';
                $vid_zanatia = isset($_GET['vid_zanatia']) ? $_GET['vid_zanatia'] : '';
                $ot_praes = isset($_GET['ot_praes']) ? $_GET['ot_praes'] : '';
                $do_praes = isset($_GET['do_praes']) ? $_GET['do_praes'] : '';
                $sotrydnik = isset($_GET['sotrydnik']) ? $_GET['sotrydnik'] : '';
                $regionSelect = isset($_GET['regionSelect']) ? $_GET['regionSelect'] : '';
                $oflaen = isset($_GET['oflaen']) ? $_GET['oflaen'] : '';
                $bez_dosvidy = isset($_GET['bez_dosvidy']) ? $_GET['bez_dosvidy'] : '';

                $sql = "SELECT id, work, name, ot_praes, do_praes, opus_vakansii FROM vakancia WHERE 1=1";

                if ($search != '') {
                    $sql .= " AND (work LIKE '%$search%' OR opus_vakansii LIKE '%$search%')";
                }
                if ($vid_zanatia != '') {
                    $sql .= " AND vid_zanatia = '$vid_zanatia'";
                }
                if ($ot_praes != '') {
                    $sql .= " AND ot_praes >= '$ot_praes'";
                }
                if ($do_praes != '') {
                    $sql .= " AND do_praes <= '$do_praes'";
                }
                if ($sotrydnik != '') {
                    $sql .= " AND sotrydnik = '$sotrydnik'";
                }
                if ($regionSelect != '') {
                    $sql .= " AND locatin = '$regionSelect'";
                }
                if ($oflaen != '') {
                    $sql .= " AND oflaen = 1";
                }
                if ($bez_dosvidy != '') {
                    $sql .= " AND bez_dosvidy = 1";
                }

                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $salary = "";
                        if ($row['ot_praes'] != 0 && $row['do_praes'] != 0) {
                            $salary = $row['ot_praes'] . " - " . $row['do_praes'];
                        } elseif ($row['ot_praes'] != 0) {
                            $salary = $row['ot_praes'];
                        } elseif ($row['do_praes'] != 0) {
                            $salary = $row['do_praes'];
                        }
                        echo "<div class='vacancy'>";
                        echo "<a href='../Опис вакансії/vacancy_detail.php?id=" . $row['id'] . "' class='vacancy-link'>";
                        echo "<div class='vacancy-info'>";
                        echo "<h3>" . $row['work'] . "</h3>";
                        echo "<p>" . $row['name'] . " - " . $salary . "</p>";
                        echo "<p>" . $row['opus_vakansii'] . "</p>";
                        echo "</div>";
                        echo "</a>";

                   

                            $user_id = $_SESSION['user_id'];
                            $vacancy_id = $row['id'];

                            $favorite_sql = "SELECT * FROM user_favorites WHERE user_id = $user_id AND vacancy_id = $vacancy_id AND otmeti = 1";
                            $response_sql = "SELECT * FROM user_favorites WHERE user_id = $user_id AND vacancy_id = $vacancy_id AND vak = 1";

                            $favorited = $conn->query($favorite_sql)->num_rows > 0 ? 'favorited' : '';
                            $responded = $conn->query($response_sql)->num_rows > 0 ? 'responded' : '';

                           
                            echo "<button class='respond-button $responded' data-id='" . $row['id'] . "'>" . ($responded ? 'Обрано' : 'Відгукнутися') . "</button>";
                            echo "<button class='favorite-button $favorited' data-id='" . $row['id'] . "'>" . ($favorited ? '&#x2665;' : '&#x2661;') . "</button>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p><p>0 вакансії</p></p>";
                    }

                    $conn->close();
                    ?>
                </div>
                <script>
document.querySelectorAll('.favorite-button').forEach(button => {
    button.addEventListener('click', function() {
        var vacancyId = this.getAttribute('data-id');
        var currentState = this.classList.contains('favorited');
        var button = this;

        fetch('update_favorite.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'vacancy_id=' + vacancyId + '&current_state=' + currentState
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                button.classList.toggle('favorited');
                button.innerHTML = button.classList.contains('favorited') ? '&#x2665;' : '&#x2661;';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Помилка:', error);
            alert('Відбулася помилка під час оновлення даних.');
        });
    });
});

document.querySelectorAll('.respond-button').forEach(button => {
    button.addEventListener('click', function() {
        var vacancyId = this.getAttribute('data-id');
        var currentState = this.classList.contains('responded');
        var button = this;

        fetch('update_response.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'vacancy_id=' + vacancyId + '&current_state=' + currentState
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                button.classList.toggle('responded');
                button.innerHTML = button.classList.contains('responded') ? 'Обрано' : 'Відгукнутися';
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Помилка:', error);
            alert('Відбулася помилка під час оновлення даних.');
        });
    });
});
</script>            </div>
        </section>
        
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

        
    </main>

</body>
</html>
