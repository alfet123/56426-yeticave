<?php
session_start();

require_once 'autoload.php';

if (!Auth::isAuth()) {
    header("Location: login.php");
    exit;
}

$categories = CategoryFinder::getAll();

$form = new AddForm();

// Проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form->checkEmpty();

    $form->checkNumberFields();

    $form->saveLotImage();

    $form->saveNewLot();

}

$templates = [
    'header' => ['avatar' => Auth::getAvatar()],
    'add_main' => ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->formMessages],
    'footer' => ['categories' => $categories]
];

renderDocument('Добавление лота', $templates);

?>
