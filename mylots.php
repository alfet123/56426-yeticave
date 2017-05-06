<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("HTTP/1.0 403 Forbidden");
    echo "Доступ запрещен";
    exit;
}

// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными
require_once 'data.php';

if (isset($_COOKIE['mybets'])) {
    $mybetsFromCookie = json_decode($_COOKIE['mybets']);
    $mybets = [];
    foreach ($mybetsFromCookie as $key => $value) {
        $mybets[] = json_decode($value, true);
    }
}

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои ставки</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', []); ?>

<?=includeTemplate('templates/mylots_main.php', ['categories' => $categories, 'lots' => $lots, 'mybets' => $mybets, 'lot_time_remaining' => $lot_time_remaining]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
