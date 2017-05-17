<?php
session_start();

require_once 'autoload.php';

if (!User::isAuth()) {
    header("Location: login.php");
    exit;
}

$categories = Category::getAll();

// массив для данных из формы
$formData = [
    'name' => '',
    'category' => '',
    'description' => '',
    'price' => '',
    'step' => '',
    'date_expire' => ''
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

}

// проверка, что форма заполнена полностью
if (isset($_POST['send']) && empty($formClasses['form'])) {
    // Добавление лота
    $now = getdate();

    $lotData   = [date("Y-m-d H:i:s")];
    $lotData[] = $formData['name'];
    $lotData[] = $formData['description'];
    $lotData[] = $target;
    $lotData[] = $formData['price'];
    $lotData[] = date("Y-m-d H:i:s", strtotime($formData['date_expire']." ".$now['hours'].":".$now['minutes'].":".$now['seconds']));
    $lotData[] = $formData['step'];
    $lotData[] = $_SESSION['user']['id'];
    $lotData[] = $formData['category'];

    $newId = Lot::newLot($lotData);

    header("Location: lot.php?id=$newId");
    exit;
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

<?=includeTemplate('templates/header.php', ['avatar' => User::getAvatar()]); ?>

<?=includeTemplate('templates/add_main.php', ['categories' => $categories, 'data' => $formData, 'class' => $formClasses, 'message' => $formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
