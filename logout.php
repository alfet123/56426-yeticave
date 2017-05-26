<?php
use YetiCave\auth;

session_start();

require_once 'autoload.php';

Auth::logout();

header("Location: /");
?>
