<?php
// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными
require_once 'data.php';

// массив для данных из формы
$formData = [
    'lot-name' => '',
    'category' => '',
    'message' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-date' => ''
];

foreach ($formData as $key) {
    // массив для дополнительных классов
    $formClasses[$key] = '';
    // массив для сообщений
    $formMessages[$key] = '';
}
$formClasses['form'] = '';

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    //проверка пустых значений
    foreach ($formData as $key => $value) {
        if (empty($_POST[$key])) {
            $formClasses['form'] = 'form--invalid';
            $formClasses[$key] = 'form__item--invalid';
            $formMessages[$key] = 'Заполните это поле';
        } else {
            $formData[$key] = $_POST[$key];
        }
    }

    //проверка числовых значений
    if (!empty($formData['lot-rate']) && !is_numeric($formData['lot-rate'])) {
        $formClasses['form'] = 'form--invalid';
        $formClasses['lot-rate'] = 'form__item--invalid';
        $formMessages['lot-rate'] = 'Введите числовое значение';
    }
    if (!empty($formData['lot-step']) && !is_numeric($formData['lot-step'])) {
        $formClasses['form'] = 'form--invalid';
        $formClasses['lot-step'] = 'form__item--invalid';
        $formMessages['lot-step'] = 'Введите числовое значение';
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
        }
    }

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

<?=includeTemplate('templates/lot_header.php', []); ?>

<?=includeTemplate('templates/add_main.php', ['categories' => $categories, 'data' => $formData, 'class' => $formClasses, 'message' => $formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
