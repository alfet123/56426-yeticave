<?php
session_start();

require_once 'functions.php';
require_once 'classes/database.php';
require_once 'classes/category.php';
require_once 'classes/lot.php';
require_once 'classes/user.php';

DataBase::connect($config);

$categories = Category::getAll();
$lots = Lot::getLots();

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Главная</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', ['avatar' => User::getAvatar()]); ?>

<?=includeTemplate('templates/main.php', ['categories' => $categories, 'lots' => $lots, 'lot_time_remaining' => $lot_time_remaining]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
