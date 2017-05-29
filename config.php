<?php

// установка часового пояса
date_default_timezone_set('Europe/Moscow');

// значения для подключения к базе данных
$DBCONFIG = [
    'host' => 'localhost',
    'user' => 'yeticave',
    'pass' => 'yeticave',
    'name' => 'yeticave'
];

// значение ограничения на количество записей в результате запроса
$ROWS_LIMIT = 9;

?>
