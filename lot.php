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

$form = new LotForm();

$form->initExtraData($lotCurrent, $bets);

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form->checkEmpty();

    $form->checkBetValue();

    $form->saveNewBet($lotCurrent->id);

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

<?=includeTemplate('templates/lot_main.php', ['categories' => $categories, 'lot' => $lotCurrent, 'lot_extra' => $form->extraData, 'lot_time_remaining' => $lot_time_remaining, 'bets' => $bets, 'class' => $form->formClasses, 'message' => $form->formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
