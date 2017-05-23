<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

// проверка, что есть get-параметр id, если нет то 404
if (!isset($_GET['id'])) {
    header("HTTP/1.0 404 Not Found");
    echo "id is required";
    exit;
}

$lotCurrent = LotFinder::getLotById(htmlspecialchars($_GET['id']));

// если передали несуществующий id, то тоже 404
if (!$lotCurrent) {
    header("HTTP/1.0 404 Not Found");
    echo "Bad id";
    exit;
}

$bets = BetFinder::getBetsByLot($lotCurrent->id);

$lotExtraData['curr-bet'] = (count($bets)) ? getMaxBet($bets) : $lotCurrent->price;
$lotExtraData['min-bet'] = $lotExtraData['curr-bet'] + ((count($bets)) ? $lotCurrent->step : 0);

// по умолчанию разрешается делать ставку
$lotExtraData['no-bet'] = true;

// если открыт сеанс и есть ставки, проверка кто сделал последнюю ставку
if (isset($_SESSION['user']) && count($bets)) {
    if (($_SESSION['user']['id'] == $bets[0]->id)) {
        $lotExtraData['no-bet'] = false;
    }
}

$lotExtraData['class'] = '';
$lotExtraData['message'] = '';

if (isset($_POST['cost'])) {

    if (empty($_POST['cost'])) {
        $lotExtraData['class'] = 'form__item--invalid';
        $lotExtraData['message'] = 'Заполните это поле';
    } elseif (!is_numeric($_POST['cost'])) {
        $lotExtraData['class'] = 'form__item--invalid';
        $lotExtraData['message'] = 'Введите числовое значение';
    } elseif ($_POST['cost'] < $lotExtraData['min-bet']) {
        $lotExtraData['class'] = 'form__item--invalid';
        $lotExtraData['message'] = 'Минимальная ставка '.$lotExtraData['min-bet'];
    } else {
        // Добавление ставки
        $newBet = new BetRecord();

        $newBet->date = date("Y-m-d H:i:s");
        $newBet->price = htmlspecialchars($_POST['cost']);
        $newBet->user = $_SESSION['user']['id'];
        $newBet->lot = $lotCurrent->id;

        $newBet->insert();

        header("Location: mylots.php");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?=$lotCurrent->name;?></title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', ['avatar' => Auth::getAvatar()]); ?>

<?=includeTemplate('templates/lot_main.php', ['categories' => $categories, 'lot' => $lotCurrent, 'lot_extra' => $lotExtraData, 'lot_time_remaining' => $lot_time_remaining, 'bets' => $bets]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
