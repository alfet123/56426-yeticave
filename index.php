<?php
use YetiCave\auth;
use YetiCave\finders\lotfinder;
use YetiCave\finders\categoryfinder;

session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

$category = null;
$searchString = null;

if (isset($_GET['category'])) {
    foreach ($categories as $key => $value) {
        if ($value->id == $_GET['category']) {
            $category = $value;
            break;
        }
    }
}

if (isset($_GET['search']) && strlen(trim($_GET['search']))) {
    $searchString = trim($_GET['search']);
}

if ($category) {
    $lots = LotFinder::getLotsByCategory($category->id);
    $titleAddon = ' ( Категория: '.$category->name.' )';
} elseif ($searchString) {
    $lots = LotFinder::getLotsBySearchString($searchString);
    $titleAddon = ' ( Поиск: '.$searchString.' )';
} else {
    $lots = LotFinder::getLots();
    $titleAddon = '';
}

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'main' => ['categories' => $categories, 'title_addon' => $titleAddon, 'lots' => $lots, 'lot_time_remaining' => timeRemaining()],
    'footer' => ['categories' => $categories]
];

renderDocument('Главная', $templates);

?>
