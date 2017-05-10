<?php
session_start();

// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными
require_once 'data.php';

// проверка, что есть get-параметр id, если нет то 404
if (!isset($_GET['id'])) {
    header("HTTP/1.0 404 Not Found");
    echo "id is required";
    exit;
}

// если передали несуществующий id, то тоже 404
$lotId = $_GET['id'];
if (!isset($lots[$lotId])) {
    header("HTTP/1.0 404 Not Found");
    echo "Bad id";
    exit;
}

$current_lot = $lots[$lotId];
$current_lot['id'] = $lotId;
$current_lot['no-bet'] = true;
$current_lot['class'] = '';
$current_lot['message'] = '';
$current_lot['min-bet'] = getMaxBet($bets) + $current_lot['step'];

foreach ($mybets as $key => $value) {
    if ($lotId == $value['id']) {
        $current_lot['no-bet'] = false;
        break;
    }
}

if (isset($_POST['cost'])) {

    if (empty($_POST['cost'])) {
        $current_lot['class'] = 'form__item--invalid';
        $current_lot['message'] = 'Заполните это поле';
    } elseif (!is_numeric($_POST['cost'])) {
        $current_lot['class'] = 'form__item--invalid';
        $current_lot['message'] = 'Введите числовое значение';
    } elseif ($_POST['cost'] < $current_lot['min-bet']) {
        $current_lot['class'] = 'form__item--invalid';
        $current_lot['message'] = 'Минимальная ставка '.$current_lot['min-bet'];
    } else {
        $mybets[] = ['id' => $lotId, 'cost' => $_POST['cost'], 'ts' => time()];

        header("Location: mylots.php");
        exit;
    }
}

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

<?=includeTemplate('templates/header.php', []); ?>

<?=includeTemplate('templates/lot_main.php', ['categories' => $categories, 'lot' => $current_lot, 'lot_time_remaining' => $lot_time_remaining, 'bets' => $bets]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
