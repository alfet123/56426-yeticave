<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

$category = null;

if (isset($_GET['category'])) {
    foreach ($categories as $key => $value) {
        if ($value->id == $_GET['category']) {
            $category = $value;
            break;
        }
    }
}

if ($category) {
    $lots = LotFinder::getLotsByCategory($category->id);
} else {
    $lots = LotFinder::getLots();
}

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'main' => ['categories' => $categories, 'cat_name' => $category ? '('.$category->name.')' : '', 'lots' => $lots, 'lot_time_remaining' => timeRemaining()],
    'footer' => ['categories' => $categories]
];

renderDocument('Главная', $templates);

?>
