<?php
session_start();

require_once 'autoload.php';

if (!User::isAuth()) {
    header("Location: login.php");
    exit;
}

$categories = Category::getAll();

$mybets = Bet::getBetsByUser($_SESSION['user']['id']);

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

<?=includeTemplate('templates/header.php', ['avatar' => User::getAvatar()]); ?>

<?=includeTemplate('templates/mylots_main.php', ['categories' => $categories, 'mybets' => $mybets, 'lot_time_remaining' => $lot_time_remaining]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
