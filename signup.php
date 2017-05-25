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

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'signup_main' => ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->formMessages],
    'footer' => ['categories' => $categories]
];

renderDocument('Регистрация', $templates);

?>
