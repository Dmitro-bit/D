<?php
echo <<<HTML
<style>
.search {
    list-style-type: none;
    padding: 0;
    margin: 0;
    text-align: left;
    position: absolute;
    z-index: 999; 
    width: 465px;
    margin-top: -10px;
    background-color: #ffffff;
    border: 1px solid #ddd;
    border-top: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    cursor: pointer;
    border-radius: 0 0 10px 10px; 
}

.search li {
    padding: 12px 20px;
    border-bottom: 1px solid #ddd;
    transition: background-color 0.3s, padding 0.3s;
    color: #333; 
}

.search li:hover {
    background-color: #f0f0f0;
    padding-left: 25px; 
}

.search li a {
    font-size: 18px;
    color: #333; 
    text-decoration: none;
    transition: color 0.3s;
}

.search li a:hover {
    color: red; 
}

.search li:last-child {
    border-bottom: none; 
}

@media (max-width: 1430px) {
    .search {
        width: 420px;
    }
}

@media (max-width: 1208px) {
    .search {
        width: 350px;
    }
}

@media (max-width: 1165px) {
    .search {
        width: 340px;
    }
}

@media (max-width: 992px) {
    .search {
        width: 295px;
    }
}

@media (max-width: 782px) {
    .search {
        width: 250px;
    }

    .search li {
        padding: 10px 15px;
    }

    .search li a {
        font-size: 16px;
    }
}

@media (max-width: 560px) {
    .search {
        width: 220px;
    }

    .search li {
        padding: 8px 12px;
    }

    .search li a {
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .search {
        width: 220px;
    }

    .search li {
        padding: 6px 10px;
    }

    .search li a {
        font-size: 12px;
    }
}

@media (max-width: 360px) {
    .search {
        width: 120px;
    }

    .search li {
        padding: 5px 8px;
    }

    .search li a {
        font-size: 10px;
    }
}

</style>
HTML;

$conn = new mysqli("localhost", "root", "", "rab");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchTerm = isset($_REQUEST['search']) ? $_REQUEST['search'] : '';
$region = isset($_REQUEST['regionSelect']) ? $_REQUEST['regionSelect'] : 'Будь-яка';

$sql = "SELECT * FROM vakancia WHERE (work LIKE '%" . $searchTerm . "%' OR opus_vakansii LIKE '%" . $searchTerm . "%')";
if ($region !== 'Будь-яка') {
    $sql .= " AND locatin = '" . $region . "'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<ul class='search'>";
    while($row = $result->fetch_assoc()) {
        echo "<li><a href='../Опис вакансії/vacancy_detail.php?id=" . $row['id'] . "&work=" . urlencode($row['work']) . "&opus_vakansii=" . urlencode($row['opus_vakansii']) . "&locatin=" . urlencode($row['locatin']) . "'>" . $row["work"] . " - " . $row["opus_vakansii"] . "</a></li>";
    }
    echo "</ul>";
} else {
    echo "<ul class='search'><li>Такої вакансії немає</li></ul>";
}

$conn->close();
?>


