<?php
session_start();

// подключение файла с функциями
require_once 'functions.php';

// проверка аутентификации
requireAuthentication();

$link = dbConnect($db);

if ($link) {
    $categories = getCategories($link);
    $mybets = getBetsByUser($link, $_SESSION['user']['id']);
    mysqli_close($link);
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

<?=includeTemplate('templates/header.php', ['avatar' => getAvatar()]); ?>

<?=includeTemplate('templates/mylots_main.php', ['categories' => $categories, 'mybets' => $mybets, 'lot_time_remaining' => $lot_time_remaining]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
