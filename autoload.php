<?php

require_once 'functions.php';

$classes = [
    'DataBase' => 'classes/database.php',
    'Category' => 'classes/category.php',
    'User' => 'classes/user.php',
    'Lot' => 'classes/lot.php',
    'Bet' => 'classes/bet.php'
];

spl_autoload_register(function ($class) {
    global $classes;
    if (isset($classes[$class])) {
        include $classes[$class];
    }
});

?>
