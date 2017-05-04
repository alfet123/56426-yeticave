<?php
// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными
require_once 'data.php';

// массив для данных из формы
$formData = [
    'email' => '',
    'password' => ''
];

// массив для дополнительных классов
$formClasses = [
    'email' => '',
    'password' => '',
    'form' => ''
];

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    //проверка пустых значений
    foreach ($formData as $key => $value) {
        if (empty($_POST[$key])) {
            $formClasses['form'] = 'form--invalid';
            $formClasses[$key] = 'form__item--invalid';
        } else {
            $formData[$key] = $_POST[$key];
        }
    }

}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/lot_header.php', []); ?>

<?=includeTemplate('templates/login_main.php', ['categories' => $categories, 'data' => $formData, 'class' => $formClasses]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
