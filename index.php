<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

$lots = LotFinder::getLots();

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'main' => ['categories' => $categories, 'lots' => $lots, 'lot_time_remaining' => timeRemaining()],
    'footer' => ['categories' => $categories]
];

renderDocument('Главная', $templates);

?>
