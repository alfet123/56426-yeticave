<?php
use YetiCave\auth;

session_start();

require_once 'vendor/autoload.php';

Auth::logout();

header("Location: /");
?>
