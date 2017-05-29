<?php
use YetiCave\auth;
use YetiCave\finders\lotfinder;
use YetiCave\finders\basefinder;
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
    $lotsCount = BaseFinder::getLotsCount('category', $category->id);
    $pages = pagesParam($lotsCount);
    $lots = LotFinder::getLotsByCategory($category->id, $ROWS_LIMIT, $pages['offset']);
    $titleAddon = ' ( Категория: '.$category->name.' )';
} elseif ($searchString) {
    $lotsCount = BaseFinder::getLotsCount('search', $searchString);
    $pages = pagesParam($lotsCount);
    $lots = LotFinder::getLotsBySearchString($searchString, $ROWS_LIMIT, $pages['offset']);
    $titleAddon = ' ( Поиск: '.$searchString.' )';
} else {
    $lotsCount = BaseFinder::getLotsCount();
    $pages = pagesParam($lotsCount);
    $lots = LotFinder::getLots([], $ROWS_LIMIT, $pages['offset']);
    $titleAddon = '';
}

$mainData = [
    'categories' => $categories,
    'title_addon' => $titleAddon,
    'lots' => $lots
];

if ($lotsCount > $ROWS_LIMIT) {
    $page = [];
    $page['count'] = $pages['count'];
    $page['current'] = $pages['current'];
    $page['prev'] = ($page['current'] > 1) ? $page['current'] - 1 : 0;
    $page['next'] = ($page['current'] < $page['count']) ? $page['current'] + 1 : 0;
    $page['param'] = $category ? 'category='.$category->id.'&' : ($searchString ? 'search='.$searchString.'&' : '');

    $mainData['page'] = $page;
}

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'main' => $mainData,
    'footer' => ['categories' => $categories]
];

renderDocument('Главная', $templates);

?>
