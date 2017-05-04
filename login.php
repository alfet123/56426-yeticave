<?php
session_start();

// подключение файла с функциями
require_once 'functions.php';

// подключение файла с данными
require_once 'data.php';

// подключение файла с пользователями
require_once 'userdata.php';

// массив для данных из формы
$formData = [
    'email' => '',
    'password' => ''
];

foreach ($formData as $key => $value) {
    // массив для дополнительных классов
    $formClasses[$key] = $value;
    // массив для сообщений
    $formMessages[$key] = $value;
}
$formClasses['form'] = '';

// функция установки класса и сообщения при ошибке на форме
function setFormError($field, $message)
{
    global $formClasses, $formMessages;
    $formClasses['form'] = 'form--invalid';
    $formClasses[$field] = 'form__item--invalid';
    $formMessages[$field] = $message;
}

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    //проверка поля email
    if (empty($_POST['email'])) {
        setFormError('email', 'Введите e-mail');
    } else {
        $formData['email'] = $_POST['email'];
    }

    //проверка поля password
    if (empty($_POST['password'])) {
        setFormError('password', 'Введите пароль');
    } else {
        $formData['password'] = $_POST['password'];
    }

}

// проверка, что форма заполнена полностью
if (isset($_POST['send']) && empty($formClasses['form'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // аутентификация
    if ($user = searchUserByEmail($email, $users)) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;
            header("Location: /");
        } else {
            $formData['password'] = '';
            setFormError('password', 'Вы ввели неверный пароль');
        }
    } else {
        $formData['email'] = '';
        setFormError('email', 'Вы ввели неверный e-mail');
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
