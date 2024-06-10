<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Головна</title>
    <link rel="icon" type="images/x-icon" href="../Фото/free-icon-vacancy.png">
    <link rel="stylesheet" href="Головна7.css">
    <link rel="stylesheet" href="adept1.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
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
            echo '<a href="../Шукач/user_info.php?user_id=' . $_SESSION['user_id'] . '" class="user-button">' . $_SESSION['user_name'] . ' ' . $_SESSION['user_surname'] . '</a>';
        } else {
            echo '<button id="loginButton" class="auth-button">Увійти</button>';
            echo '<button id="registerButton" class="auth-button">Зареєструватися</button>';
        }
        ?>
    </div>
</div>
</header>

<main>
    <div class="hero">
        <div class="container">
            <div class="hero-content">
                <h1>Усе для вас</h1>
                <div class="search-container">
                    <form action="../Вакансії/Вакансії.php" method="GET">
                        <input type="text" name="search" id="search" class="pochykpole" placeholder="Ким або в якій компанії хочете працювати?"> 
                        <input type="submit" class="pochykknopka" value="Пошук">
                        <div class="search-results"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>




<div class="fon">

        <section class="recruiting">
    <div class="container">
        <h2>Бажаєте розмістити свою вакансію?</h2>
        <div class="recruiting-buttons">
            <a href="../Зар_адмін/login_admin.html"><button>Увійти</button></a>
            <a href="../Зар_адмін/zar_admin.html"><button>Зареєструватися (як роботодавець)</button></a>
        </div>
    </div>
</section>





        <section class="partners">
            <div class="container">
            <h2>Популярні вакансії</h2>
            <div class="vacancies">
                <?php

                $conn = new mysqli('localhost', 'root', '', 'rab');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }


                $sql = "SELECT v.id, v.work, v.opus_vakansii, COUNT(uf.id) as favorite_count
                        FROM vakancia v
                        LEFT JOIN user_favorites uf ON v.id = uf.vacancy_id
                        GROUP BY v.id, v.work, v.opus_vakansii
                        ORDER BY favorite_count DESC
                        LIMIT 6";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {

                    while($row = $result->fetch_assoc()) {

                        echo '<a href="../Опис вакансії/vacancy_detail.php?id=' . $row["id"] . '" class="vacancy">';
                        echo '<div>';
                        echo '<h3>' . $row["work"] . '</h3>';
                        echo '<p>' . $row["opus_vakansii"] . '</p>';
                        echo '<p class="favorite-count">Кількість популярності: ' . $row["favorite_count"] . '</p>';
                        echo '</div>';
                        echo '</a>';
                    }
                } else {
                    echo "Популярних вакансій немає.";
                }

                $conn->close();
                ?>
            </div>




         



            </div>


        </section>


    </main>

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


</div>

<script src="js.js"></script>

</body>
</html>
