<?php
use YetiCave\auth;
use YetiCave\forms\lotform;
use YetiCave\finders\lotfinder;
use YetiCave\finders\betfinder;
use YetiCave\finders\categoryfinder;

session_start();

require_once 'vendor/autoload.php';

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

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'lot_main' => ['categories' => $categories, 'lot' => $lotCurrent, 'lot_extra' => $form->extraData, 'lot_time_remaining' => timeRemaining(), 'bets' => $bets, 'class' => $form->formClasses, 'message' => $form->errorMessages],
    'footer' => ['categories' => $categories]
];

renderDocument($lotCurrent->name, $templates);

?>
