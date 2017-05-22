<?php

require_once 'functions.php';

$classes = [
    'DataBase' => 'classes/database.php',
    'User' => 'classes/user.php',
    'BaseRecord' => 'classes/baserecord.php',
    'UserRecord' => 'classes/userrecord.php',
    'CategoryRecord' => 'classes/categoryrecord.php',
    'LotRecord' => 'classes/lotrecord.php',
    'BetRecord' => 'classes/betrecord.php',
    'BaseFinder' => 'classes/basefinder.php',
    'UserFinder' => 'classes/userfinder.php',
    'CategoryFinder' => 'classes/categoryfinder.php',
    'LotFinder' => 'classes/lotfinder.php',
    'BetFinder' => 'classes/betfinder.php'
];

spl_autoload_register(function ($class) {
    global $classes;
    if (isset($classes[$class])) {
        include $classes[$class];
    }
});

?>
