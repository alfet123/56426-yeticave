<?php
// подключение файла с функциями
require_once 'functions.php';

// массив для данных из формы
$formData = [
    'lot-name' => '',
    'category' => '',
    'message' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-date' => '',
    'lot-image' => ''
];

// массив для дополнительных классов
$formClasses = [
    'form' => '',
    'lot-name' => '',
    'category' => '',
    'message' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-date' => '',
    'lot-image' => ''
];

// массив для сообщений
$formMessages = [
    'lot-name' => '',
    'category' => '',
    'message' => '',
    'lot-rate' => '',
    'lot-step' => '',
    'lot-date' => ''
];

//проверка пустых значений
foreach ($formData as $key => $value) {
    if (isset($_POST[$key])) {
        $formData[$key] = $_POST[$key];
        if (empty($formData[$key])) {
            $formClasses['form'] = 'form--invalid';
            $formClasses[$key] = 'form__item--invalid';
            $formMessages[$key] = 'Заполните это поле';
        }
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

<?=includeTemplate('templates/add_main.php', ['data' => $formData, 'class' => $formClasses, 'message' => $formMessages]); ?>

<?=includeTemplate('templates/footer.php', []); ?>

</body>
</html>
