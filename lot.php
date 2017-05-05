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

$mybets = [];
if (isset($_COOKIE['mybets'])) {
    $mybets = json_decode($_COOKIE['mybets']);
}

foreach ($mybets as $key => $value) {
    $bet = json_decode($value, true);
    if ($lotId == $bet['id']) {
        $current_lot['no-bet'] = false;
        break;
    }
}

if (isset($_POST['cost'])) {

    $bet['id'] = $lotId;
    $bet['cost'] = $_POST['cost'];
    $bet['ts'] = time();

    $mybets[] = json_encode($bet);

    $name = 'mybets';
    $value = json_encode($mybets);
    $expire = strtotime("+30 days");
    $path = '/';

    setcookie($name, $value, $expire, $path);

    header("Location: mylots.php");
    exit;
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
