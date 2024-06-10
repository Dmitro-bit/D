 <?php
$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = intval($_GET['id']);

$sql = "SELECT * FROM vakancia WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $sotrydnik_options = [
        1 => "Для всіх",
        2 => "Студент",
        3 => "Люди з інвалідністю",
        4 => "Ветеранам",
        5 => "Пенсіонерам"
    ];
    $sotrydnik = $sotrydnik_options[$row['sotrydnik']] ?? "Не визначено";

    $vid_zanatia_options = [
        1 => "Повна",
        2 => "Неповна",
        3 => "Позмінна"
    ];
    $vid_zanatia = $vid_zanatia_options[$row['vid_zanatia']] ?? "Не визначено";
    ?>

    
    <!DOCTYPE html>
    <html lang="uk">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo htmlspecialchars($row['work']); ?> - Деталі вакансії</title>
        <link rel="stylesheet" href="vacancy_detail3.css">
        <link rel="stylesheet" href="adept.css">
        <link rel="icon" type="images/x-icon" href="../Фото/free-icon-vacancy.png">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    </head>
    <body>
        



 <div class="search-section">
            



 <?php
session_start();
?>

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



<main>


<div class="container">
    <div class="button-group">
      <button class="back-button" onclick="history.back()">&#x2190; Повернутися назад</button>
        <div class="right-buttons">
            <?php
            $user_id = $_SESSION['user_id'];
            $vacancy_id = $row['id'];

            $favorite_sql = "SELECT * FROM user_favorites WHERE user_id = $user_id AND vacancy_id = $vacancy_id AND otmeti = 1";
            $response_sql = "SELECT * FROM user_favorites WHERE user_id = $user_id AND vacancy_id = $vacancy_id AND vak = 1";

            $favorited = $conn->query($favorite_sql)->num_rows > 0 ? 'favorited' : '';
            $responded = $conn->query($response_sql)->num_rows > 0 ? 'responded' : '';

            echo "<button class='respond-button $responded' data-id='" . $row['id'] . "'>" . ($responded ? 'Обрано' : 'Відгукнутися') . "</button>";
            echo "<button class='favorite-button $favorited' data-id='" . $row['id'] . "'>" . ($favorited ? '&#x2665;' : '&#x2661;') . "</button>";
            ?>
        </div>
    </div>
    <div class="vacancy-detail">
        <h2><?php echo htmlspecialchars($row['work']); ?></h2>
        <p><strong>Компанія:</strong> <?php echo htmlspecialchars($row['name']); ?></p>
        <p><strong>Вид зайнятості:</strong> <?php echo htmlspecialchars($vid_zanatia); ?></p>
        <p><strong>Зарплата:</strong>
            <?php 
            if ($row['ot_praes'] != 0 && $row['do_praes'] != 0) {
                echo htmlspecialchars($row['ot_praes']) . " - " . htmlspecialchars($row['do_praes']);
            } elseif ($row['ot_praes'] != 0) {
                echo htmlspecialchars($row['ot_praes']);
            } elseif ($row['do_praes'] != 0) {
                echo htmlspecialchars($row['do_praes']);
            } else {
                echo "Будь-яка";
            }
            ?>
        </p>
        <p><strong>Дистанційна робота:</strong> <?php echo $row['oflaen'] ? 'Так' : 'Ні'; ?></p>
        <p><strong>Без досвіду:</strong> <?php echo $row['bez_dosvidy'] ? 'Так' : 'Ні'; ?></p>
        <p><strong>Підходить для:</strong> <?php echo htmlspecialchars($sotrydnik); ?></p>
        <p><strong>Короткий опис вакансії:</strong> <?php echo htmlspecialchars($row['opus_vakansii']); ?></p>
        <p><strong>Опис компанії:</strong> <?php echo htmlspecialchars($row['kr_pro_komp']); ?></p>
        <p><strong>Вимоги:</strong> <?php echo htmlspecialchars($row['vumogu']); ?></p>
        <p><strong>Обов'язки:</strong> <?php echo htmlspecialchars($row['obov']); ?></p>
        <p><strong>Умови роботи:</strong> <?php echo htmlspecialchars($row['umovu_rab']); ?></p>
        <p><strong>Місцезнаходження компанії:</strong> <?php echo htmlspecialchars($row['locatin']); ?></p>
    </div>
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
</script>



            
          <!-- Disqus Comment Section -->
        
    </main>


<div id="disqus_thread"></div>
<script>
    /**
    *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
    *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
    /*
    var disqus_config = function () {
    this.page.url = PAGE_URL;  // Replace PAGE_URL with your page's canonical URL variable
    this.page.identifier = PAGE_IDENTIFIER; // Replace PAGE_IDENTIFIER with your page's unique identifier variable
    };
    */
    (function() { // DON'T EDIT BELOW THIS LINE
    var d = document, s = d.createElement('script');
    s.src = 'https://vak-2.disqus.com/embed.js';
    s.setAttribute('data-timestamp', +new Date());
    (d.head || d.body).appendChild(s);
    })();
</script>
<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>

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


<script id="dsq-count-scr" src="//vak-2.disqus.com/count.js" async></script>

    </body>
    </html>
    <?php
} else {
    echo "Вакансія не знайдена.";
}

$conn->close();
?>
