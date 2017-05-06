<?php
session_start();

// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными
require_once 'data.php';

// проверка аутентификации
requireAuthentication();

// массив для данных из формы
$formData = [
    'lot-name' => '',
    'category' => '',
    'message' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-date' => ''
];

// массив для дополнительных классов
$formClasses = ['form' => ''];
// массив для сообщений
$formMessages = [];

foreach ($formData as $key => $value) {
    $formClasses[$key] = $value;
    $formMessages[$key] = $value;
}

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    //проверка пустых значений
    foreach ($formData as $key => $value) {
        if (empty($_POST[$key])) {
            setFormError($formClasses, $formMessages, $key, 'Заполните это поле');
        } else {
            $formData[$key] = $_POST[$key];
        }
    }

    //проверка числовых значений
    if (!empty($formData['lot-rate']) && !is_numeric($formData['lot-rate'])) {
        setFormError($formClasses, $formMessages, 'lot-rate', 'Введите числовое значение');
    }
    if (!empty($formData['lot-step']) && !is_numeric($formData['lot-step'])) {
        setFormError($formClasses, $formMessages, 'lot-step', 'Введите числовое значение');
    }

    // cохранение загруженного файла
    if (isset($_FILES['lot-image'])) {
        $file = $_FILES['lot-image'];
        $filename = $file['name'];
        $source = $file['tmp_name'];
        $target = "img/$filename";
        if (move_uploaded_file($source, $target)) {
            $formData['lot-image'] = $target;
            $formClasses['lot-image'] = 'form__item--uploaded';
        } else {
            setFormError($formClasses, $formMessages, 'lot-image', 'Выберите файл для загрузки');
        }
    }

}

// проверка, что форма заполнена полностью
if (isset($_POST['send']) && empty($formClasses['form'])) {
    $template = 'templates/main.php';
    array_unshift($lots, ['name' => $formData['lot-name'], 'category' => $categories[$formData['category']-1], 'price' => $formData['lot-rate'], 'image' => $formData['lot-image'], 'description' => $formData['message']]);
    $data = ['categories' => $categories, 'lots' => $lots, 'lot_time_remaining' => $lot_time_remaining];
} else {
    $template = 'templates/add_main.php';
    $data = ['categories' => $categories, 'data' => $formData, 'class' => $formClasses, 'message' => $formMessages];
}

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

<?=includeTemplate('templates/header.php', []); ?>

<?=includeTemplate($template, $data); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
