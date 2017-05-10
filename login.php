<?php
session_start();

// подключение файла с функциями
require_once 'functions.php';

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
    if ($user = getUserByEmail($email)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /");
            exit;
        } else {
            $formData['password'] = '';
            setFormError($formClasses, $formMessages, 'password', 'Вы ввели неверный пароль');
        }
    } else {
        $formData['email'] = '';
        setFormError($formClasses, $formMessages, 'email', 'Вы ввели неверный e-mail');
    }

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

<?=includeTemplate('templates/header.php', []); ?>

<?=includeTemplate('templates/login_main.php', ['categories' => $categories, 'data' => $formData, 'class' => $formClasses, 'message' => $formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
