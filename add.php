<?php
session_start();

require_once 'autoload.php';

if (!Auth::isAuth()) {
    header("Location: login.php");
    exit;
}

$categories = CategoryFinder::getAll();

$form = new AddForm();

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form->checkEmpty();

/*
    //проверка числовых значений
    if (!empty($formData['price']) && !is_numeric($formData['price'])) {
        setFormError($formClasses, $formMessages, 'price', 'Введите числовое значение');
    }
    if (!empty($formData['step']) && !is_numeric($formData['step'])) {
        setFormError($formClasses, $formMessages, 'step', 'Введите числовое значение');
    }

    // cохранение загруженного файла
    if (isset($_FILES['image'])) {
        $file = $_FILES['image'];
        $filename = $file['name'];
        $source = $file['tmp_name'];
        $target = "img/$filename";
        if (move_uploaded_file($source, $target)) {
            $formData['image'] = $target;
            $formClasses['image'] = 'form__item--uploaded';
        } else {
            setFormError($formClasses, $formMessages, 'image', 'Выберите файл для загрузки');
        }
    }
*/

}

// проверка, что форма заполнена полностью
/*
if (isset($_POST['send']) && empty($formClasses['form'])) {
    // Добавление лота
    $now = getdate();

    $newLot = new LotRecord();

    $newLot->date_create = date("Y-m-d H:i:s");
    $newLot->name = $formData['name'];
    $newLot->description = $formData['description'];
    $newLot->image = $target;
    $newLot->price = $formData['price'];
    $newLot->date_expire = date("Y-m-d H:i:s", strtotime($formData['date_expire']." ".$now['hours'].":".$now['minutes'].":".$now['seconds']));
    $newLot->step = $formData['step'];
    $newLot->owner = $_SESSION['user']['id'];
    $newLot->category = $formData['category'];

    $newLot->insert();

    header("Location: lot.php?id=".$newLot->id);
    exit;
}
*/

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Добавление лота</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', ['avatar' => Auth::getAvatar()]); ?>

<?=includeTemplate('templates/add_main.php', ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
