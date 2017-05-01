<?php
// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными лотов
require_once 'lots_data.php';

$current_lot = null;
if (isset($_GET[id])) {
    if (isset($lots[$_GET[id]])) {
        $current_lot = $lots[$_GET[id]];
    } else {
        print("Недопустимое значение параметра ID");
    }
} else {
    print("Нет параметра ID");
}

// ставки пользователей, которыми надо заполнить таблицу
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=$current_lot['name']?></title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/lot_header.php', []); ?>

<?=includeTemplate('templates/lot_main.php', ['lot' => $current_lot, 'bets' => $bets]); ?>

<?=includeTemplate('templates/footer.php', []); ?>

</body>
</html>
