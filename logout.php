<?php
session_start();

require_once 'autoload.php';

User::logout();

header("Location: /");
?>
