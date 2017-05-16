<?php
session_start();

require_once 'classes/user.php';

User::logout();

header("Location: /");
?>
