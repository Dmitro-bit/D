<?php
$conn = new mysqli("localhost", "root", "", "rab");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_POST['admin_id'])) {
    echo "Вакансия не найдена.";
    exit();
}

$id = $_POST['admin_id'];
$query = "SELECT * FROM vakancia WHERE id = ?";
$stmt = $conn->prepare($query);

if ($stmt === false) {
    die("Ошибка подготовки запроса: " . $conn->error);
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $vacancy = $result->fetch_assoc();
} else {
    echo "Вакансия не найдена.";
    exit();
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
    <link rel="stylesheet" href="edit_vacancy.css">
    <title>Редагування вакансії</title>

</head>
<body>
   <form action="update_vacancy.php" method="post">
    <button class="back-button" type="button" onclick="history.back()">&#x2190;</button>
    <input type="hidden" name="id" value="<?php echo htmlspecialchars($vacancy['id']); ?>">
    




<div>
            <div class="char-limit" id="workLimit">Залишилось символів: 50</div>
            <label for="work">Назва вакансії:</label>
            <input type="text" id="work" name="work" value="<?php echo htmlspecialchars($vacancy['work']); ?>" required maxlength="50" oninput="checkLength(this, 50, workLimit)">
        </div>

        <div>
            <div class="char-limit" id="nameLimit">Залишилось символів: 50</div>
            <label for="name">Назва компанії:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($vacancy['name']); ?>" required maxlength="50" oninput="checkLength(this, 50, nameLimit)">
        </div>




    
    <label for="vid_zanatia">Вид зайнятості:</label>
    <select name="vid_zanatia" id="vid_zanatia" required>
        <option value="1" <?php if ($vacancy['vid_zanatia'] == 1) echo "selected"; ?>>Повна</option>
        <option value="2" <?php if ($vacancy['vid_zanatia'] == 2) echo "selected"; ?>>Неповна</option>
        <option value="3" <?php if ($vacancy['vid_zanatia'] == 3) echo "selected"; ?>>Позмінна</option>
    </select><br>
   



<label for="do_praes">Максимальна зарплата:</label>
<input type="text" id="do_praes" name="do_praes" min="0" pattern="[0-9]*" value="<?php echo htmlspecialchars($vacancy['do_praes']); ?>" oninput="handleInput(this); updateMinPrice()" required><br>


    <label for="ot_praes">Мінімальна зарплата:</label>
<input type="text" id="ot_praes" name="ot_praes" min="0" pattern="[0-9]*" value="<?php echo htmlspecialchars($vacancy['ot_praes']); ?>" oninput="handleInput(this); updateMaxPrice()" required><br>



    
    <label for="oflaen">Дистанційна робота:</label>
    <input type="checkbox" id="oflaen" name="oflaen" <?php if ($vacancy['oflaen']) echo "checked"; ?>><br>
    
    <label for="bez_dosvidy">Без досвіду:</label>
    <input type="checkbox" id="bez_dosvidy" name="bez_dosvidy" <?php if ($vacancy['bez_dosvidy']) echo "checked"; ?>><br>
    
    <label for="sotrydnik">Підходить для:</label>
    <select name="sotrydnik" id="sotrydnik" required>
        <option value="1" <?php if ($vacancy['sotrydnik'] == 1) echo "selected"; ?>>Для всіх</option>
        <option value="2" <?php if ($vacancy['sotrydnik'] == 2) echo "selected"; ?>>Студент</option>
        <option value="3" <?php if ($vacancy['sotrydnik'] == 3) echo "selected"; ?>>Люди з інвалідністю</option>
        <option value="4" <?php if ($vacancy['sotrydnik'] == 4) echo "selected"; ?>>Ветеранам</option>
        <option value="5" <?php if ($vacancy['sotrydnik'] == 5) echo "selected"; ?>>Пенсіонерам</option>
    </select><br>
    
   <div>
        <div class="char-limit" id="charLimitOpusVakansii">Залишилось символів: 100</div>
        <label for="opus_vakansii">Короткий опис вакансії:</label>
        <textarea id="opus_vakansii" name="opus_vakansii" maxlength="100" required oninput="checkLength(this, 100, 'charLimitOpusVakansii')"><?php echo htmlspecialchars($vacancy['opus_vakansii']); ?></textarea>
    </div>

    <div>
        <div class="char-limit" id="charLimitKrProKomp">Залишилось символів: 255</div>
        <label for="kr_pro_komp">Опис компанії:</label>
        <textarea id="kr_pro_komp" name="kr_pro_komp" maxlength="255" required oninput="checkLength(this, 255, 'charLimitKrProKomp')"><?php echo htmlspecialchars($vacancy['kr_pro_komp']); ?></textarea>
    </div>

    <div>
        <div class="char-limit" id="charLimitVumogu">Залишилось символів: 255</div>
        <label for="vumogu">Вимоги:</label>
        <textarea id="vumogu" name="vumogu" maxlength="255" required oninput="checkLength(this, 255, 'charLimitVumogu')"><?php echo htmlspecialchars($vacancy['vumogu']); ?></textarea>
    </div>

    <div>
        <div class="char-limit" id="charLimitObov">Залишилось символів: 255</div>
        <label for="obov">Обов'язки:</label>
        <textarea id="obov" name="obov" maxlength="255" required oninput="checkLength(this, 255, 'charLimitObov')"><?php echo htmlspecialchars($vacancy['obov']); ?></textarea>
    </div>

    <div>
        <div class="char-limit" id="charLimitUmovuRab">Залишилось символів: 255</div>
        <label for="umovu_rab">Умови роботи:</label>
        <textarea id="umovu_rab" name="umovu_rab" maxlength="255" required oninput="checkLength(this, 255, 'charLimitUmovuRab')"><?php echo htmlspecialchars($vacancy['umovu_rab']); ?></textarea>
    </div>




    
<label for="locatin">Розташування компанії:</label>
<select name="locatin" id="locatin" required>
    <option value="Будь-яка">Будь-яка</option>
    <option value="Вінницька" <?php if ($vacancy['locatin'] == 'Вінницька') echo 'selected'; ?>>Вінницька</option>
    <option value="Волинська" <?php if ($vacancy['locatin'] == 'Волинська') echo 'selected'; ?>>Волинська</option>
    <option value="Дніпропетровська" <?php if ($vacancy['locatin'] == 'Дніпропетровська') echo 'selected'; ?>>Дніпропетровська</option>
    <option value="Донецька" <?php if ($vacancy['locatin'] == 'Донецька') echo 'selected'; ?>>Донецька</option>
    <option value="Житомирська" <?php if ($vacancy['locatin'] == 'Житомирська') echo 'selected'; ?>>Житомирська</option>
    <option value="Закарпатська" <?php if ($vacancy['locatin'] == 'Закарпатська') echo 'selected'; ?>>Закарпатська</option>
    <option value="Запорізька" <?php if ($vacancy['locatin'] == 'Запорізька') echo 'selected'; ?>>Запорізька</option>
    <option value="Івано-Франківська" <?php if ($vacancy['locatin'] == 'Івано-Франківська') echo 'selected'; ?>>Івано-Франківська</option>
    <option value="Київська" <?php if ($vacancy['locatin'] == 'Київська') echo 'selected'; ?>>Київська</option>
    <option value="Кіровоградська" <?php if ($vacancy['locatin'] == 'Кіровоградська') echo 'selected'; ?>>Кіровоградська</option>
    <option value="Луганська" <?php if ($vacancy['locatin'] == 'Луганська') echo 'selected'; ?>>Луганська</option>
    <option value="Львівська" <?php if ($vacancy['locatin'] == 'Львівська') echo 'selected'; ?>>Львівська</option>
    <option value="Миколаївська" <?php if ($vacancy['locatin'] == 'Миколаївська') echo 'selected'; ?>>Миколаївська</option>
    <option value="Одеська" <?php if ($vacancy['locatin'] == 'Одеська') echo 'selected'; ?>>Одеська</option>
    <option value="Полтавська" <?php if ($vacancy['locatin'] == 'Полтавська') echo 'selected'; ?>>Полтавська</option>
    <option value="Рівненська" <?php if ($vacancy['locatin'] == 'Рівненська') echo 'selected'; ?>>Рівненська</option>
    <option value="Сумська" <?php if ($vacancy['locatin'] == 'Сумська') echo 'selected'; ?>>Сумська</option>
    <option value="Тернопільська" <?php if ($vacancy['locatin'] == 'Тернопільська') echo 'selected'; ?>>Тернопільська</option>
    <option value="Харківська" <?php if ($vacancy['locatin'] == 'Харківська') echo 'selected'; ?>>Харківська</option>
    <option value="Херсонська" <?php if ($vacancy['locatin'] == 'Херсонська') echo 'selected'; ?>>Херсонська</option>
    <option value="Хмельницька" <?php if ($vacancy['locatin'] == 'Хмельницька') echo 'selected'; ?>>Хмельницька</option>
    <option value="Черкаська" <?php if ($vacancy['locatin'] == 'Черкаська') echo 'selected'; ?>>Черкаська</option>
    <option value="Чернівецька" <?php if ($vacancy['locatin'] == 'Чернівецька') echo 'selected'; ?>>Чернівецька</option>
    <option value="Чернігівська" <?php if ($vacancy['locatin'] == 'Чернігівська') echo 'selected'; ?>>Чернігівська</option>
</select><br>


    
    <input type="submit" value="Зберегти">
</form>




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

    if (minPrice == 0 && maxPrice == 0) {
        maxPrice = 1; 
        document.getElementById("do_praes").value = maxPrice;
    }

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

    if (minPrice == 0 && maxPrice == 0) {
        minPrice = 1; 
        document.getElementById("ot_praes").value = minPrice;
    }

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

        window.addEventListener('DOMContentLoaded', (event) => {
            document.querySelectorAll('input[maxlength]').forEach(function(input) {
                var maxLength = input.getAttribute('maxlength');
                var output = document.getElementById(input.id + "Limit");
                checkLength(input, maxLength, output);
            });
        });


        function checkLength(element, maxLength, charLimitId) {
    var remaining = maxLength - element.value.length;
    document.getElementById(charLimitId).textContent = "Залишилось символів: " + remaining;
}


</script>
</body>
</html>
