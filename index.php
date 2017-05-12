<?php
session_start();

// подключение файла с функциями
require_once 'functions.php';

$link = dbConnect($db);

if ($link) {
    $categories = getCategories($link);
    $lots = getLots($link);
    mysqli_close($link);
}

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

<?=includeTemplate('templates/header.php', ['avatar' => getAvatar()]); ?>

<?=includeTemplate('templates/main.php', ['categories' => $categories, 'lots' => $lots, 'lot_time_remaining' => $lot_time_remaining]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
