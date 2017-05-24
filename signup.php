<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

$form = new SignupForm();

// Проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form->checkEmpty();

    $form->checkEmail();

    $form->saveAvatar();

    $form->saveNewUser();

}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', ['avatar' => Auth::getAvatar()]); ?>

<?=includeTemplate('templates/signup_main.php', ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
