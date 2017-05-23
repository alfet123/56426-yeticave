<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

// массив для данных из формы
$formData = [
    'email' => '',
    'password' => ''
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

    $errorMessages = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль'
    ];

    foreach ($errorMessages as $key => $value) {
        if (empty($_POST[$key])) {
            setFormError($formClasses, $formMessages, $key, $value);
        } else {
            $formData[$key] = $_POST[$key];
        }
    }

}

// проверка, что форма заполнена полностью
if (isset($_POST['send']) && empty($formClasses['form'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // аутентификация
    $user = Auth::login($email, $password);

    if ($user['auth']) {
        header("Location: /");
        exit;
    }

    $errorAuthMessages = [
        'email' => 'Вы ввели неверный e-mail',
        'password' => 'Вы ввели неверный пароль'
    ];

    $formData[$user['field']] = '';
    setFormError($formClasses, $formMessages, $user['field'], $errorAuthMessages[$user['field']]);

}

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', ['avatar' => Auth::getAvatar()]); ?>

<?=includeTemplate('templates/login_main.php', ['categories' => $categories, 'data' => $formData, 'class' => $formClasses, 'message' => $formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
