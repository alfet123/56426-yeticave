<?php
session_start();

require_once 'autoload.php';

$categories = Category::getAll();

// проверка, что есть get-параметр id, если нет то 404
if (!isset($_GET['id'])) {
    header("HTTP/1.0 404 Not Found");
    echo "id is required";
    exit;
}

$current_lot = Lot::getLotById(htmlspecialchars($_GET['id']));

// если передали несуществующий id, то тоже 404
if (!$current_lot) {
    header("HTTP/1.0 404 Not Found");
    echo "Bad id";
    exit;
}

$bets = Bet::getBetsByLot($current_lot['id']);

$current_lot['curr-bet'] = (count($bets)) ? getMaxBet($bets) : $current_lot['price'];
$current_lot['min-bet'] = $current_lot['curr-bet'] + ((count($bets)) ? $current_lot['step'] : 0);

// по умолчанию разрешается делать ставку
$current_lot['no-bet'] = true;

// если открыт сеанс и есть ставки, проверка кто сделал последнюю ставку
if (isset($_SESSION['user']) && count($bets)) {
    if (($_SESSION['user']['id'] == $bets[0]['id'])) {
        $current_lot['no-bet'] = false;
    }
}

$current_lot['class'] = '';
$current_lot['message'] = '';

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
        $betData   = [date("Y-m-d H:i:s")];
        $betData[] = htmlspecialchars($_POST['cost']);
        $betData[] = $_SESSION['user']['id'];
        $betData[] = $current_lot['id'];
        Bet::newBet($betData);
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

<?=includeTemplate('templates/header.php', ['avatar' => User::getAvatar()]); ?>

<?=includeTemplate('templates/lot_main.php', ['categories' => $categories, 'lot' => $current_lot, 'lot_time_remaining' => $lot_time_remaining, 'bets' => $bets]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
