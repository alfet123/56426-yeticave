<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

$form = new LoginForm();

// Проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form->checkEmpty();

    $form->userLogin();

}

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'login_main' => ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->errorMessages],
    'footer' => ['categories' => $categories]
];

renderDocument('Вход', $templates);

?>
