<?php
use YetiCave\auth;
use YetiCave\finders\betfinder;
use YetiCave\finders\categoryfinder;

session_start();

require_once 'vendor/autoload.php';

if (!Auth::isAuth()) {
    header("Location: login.php");
    exit;
}

$categories = CategoryFinder::getAll();

$mybets = BetFinder::getBetsByUser($_SESSION['user']['id']);

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'mylots_main' => ['categories' => $categories, 'mybets' => $mybets, 'lot_time_remaining' => timeRemaining()],
    'footer' => ['categories' => $categories]
];

renderDocument('Мои ставки', $templates);

?>
