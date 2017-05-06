<?php

// устанавливаем часовой пояс в Московское время
date_default_timezone_set('Europe/Moscow');

// записать в эту переменную оставшееся время в этом формате (ЧЧ:ММ)
$lot_time_remaining = "00:00";

// временная метка для полночи следующего дня
$tomorrow = strtotime('tomorrow midnight');

// временная метка для настоящего времени
$now = time();

// далее нужно вычислить оставшееся время до начала следующих суток и записать его в переменную $lot_time_remaining
$lot_time_remaining = gmdate("H:i", $tomorrow - $now);

// массив категорий
$categories = ["Доски и лыжи", "Крепления", "Ботинки", "Одежда", "Инструменты", "Разное"];

// массив объявлений
$lots = [
    ["name" => "2014 Rossignol District Snowboard", "category" => "Доски и лыжи", "price" => "10999", "step" => "500", "image" => "img/lot-1.jpg", "description" => "Здесь должно быть описание для доски Rossignol District"],
    ["name" => "DC Ply Mens 2016/2017 Snowboard", "category" => "Доски и лыжи", "price" => "159999", "step" => "500", "image" => "img/lot-2.jpg", "description" => "Здесь должно быть описание для доски DC Ply Mens"],
    ["name" => "Крепления Union Contact Pro 2015 года размер L/XL", "category" => "Крепления", "price" => "8000", "step" => "300", "image" => "img/lot-3.jpg", "description" => "Здесь должно быть описание для крепления Union Contact Pro"],
    ["name" => "Ботинки для сноуборда DC Mutiny Charocal", "category" => "Ботинки", "price" => "10999", "step" => "200", "image" => "img/lot-4.jpg", "description" => "Здесь должно быть описание для ботинок DC Mutiny Charocal"],
    ["name" => "Куртка для сноуборда DC Mutiny Charocal", "category" => "Одежда", "price" => "7500", "step" => "200", "image" => "img/lot-5.jpg", "description" => "Здесь должно быть описание для куртки DC Mutiny Charocal"],
    ["name" => "Маска Oakley Canopy", "category" => "Разное", "price" => "5400", "step" => "100", "image" => "img/lot-6.jpg", "description" => "Здесь должно быть описание для маски Oakley Canopy"]
];

// ставки пользователей
$bets = [
    ['name' => 'Иван', 'price' => 11500, 'ts' => strtotime('-' . rand(1, 50) .' minute')],
    ['name' => 'Константин', 'price' => 11000, 'ts' => strtotime('-' . rand(1, 18) .' hour')],
    ['name' => 'Евгений', 'price' => 10500, 'ts' => strtotime('-' . rand(25, 50) .' hour')],
    ['name' => 'Семён', 'price' => 10000, 'ts' => strtotime('last week')]
];

?>
