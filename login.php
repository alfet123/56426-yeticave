<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form = new LoginForm();

}

// проверка, что форма заполнена полностью
/*
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
*/

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

<?=includeTemplate('templates/login_main.php', ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
