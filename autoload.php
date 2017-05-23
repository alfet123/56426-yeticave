<?php

require_once 'functions.php';

$classes = [
    'DataBase' => 'classes/database.php',
    'Auth' => 'classes/auth.php',
    'BaseRecord' => 'classes/records/baserecord.php',
    'UserRecord' => 'classes/records/userrecord.php',
    'CategoryRecord' => 'classes/records/categoryrecord.php',
    'LotRecord' => 'classes/records/lotrecord.php',
    'BetRecord' => 'classes/records/betrecord.php',
    'BaseFinder' => 'classes/finders/basefinder.php',
    'UserFinder' => 'classes/finders/userfinder.php',
    'CategoryFinder' => 'classes/finders/categoryfinder.php',
    'LotFinder' => 'classes/finders/lotfinder.php',
    'BetFinder' => 'classes/finders/betfinder.php',
    'BaseForm' => 'classes/forms/baseform.php',
    'AddForm' => 'classes/forms/addform.php',
    'LoginForm' => 'classes/forms/loginform.php',
    'LotForm' => 'classes/forms/lotform.php',
    'SignupForm' => 'classes/forms/signupform.php'
];

spl_autoload_register(function ($class) {
    global $classes;
    if (isset($classes[$class])) {
        include $classes[$class];
    }
});

?>
