<?php
session_start();

require_once 'autoload.php';

$categories = CategoryFinder::getAll();

// проверка, что была отправка формы
if (isset($_POST['send'])) {

    $form = new SignupForm();

/*
    if (!empty($_POST['email']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        setFormError($formClasses, $formMessages, 'email', 'Введите правильный e-mail');
    }

    if (UserFinder::getUserByEmail($_POST['email'])) {
        setFormError($formClasses, $formMessages, 'email', 'Пользователь с указанным e-mail уже существует');
    }

    // cохранение загруженного файла
    if (isset($_FILES['avatar'])) {
        $file = $_FILES['avatar'];
        $filename = $file['name'];
        $source = $file['tmp_name'];
        $target = "img/$filename";
        $fileMoved = move_uploaded_file($source, $target);
    }
*/

}

// проверка, что форма заполнена полностью
/*
if (isset($_POST['send']) && empty($formClasses['form'])) {
    // Добавление пользователя
    $newUser = new UserRecord();

    $newUser->date_reg = date("Y-m-d H:i:s");
    $newUser->email = $formData['email'];
    $newUser->name = $formData['name'];
    $newUser->password = password_hash($formData['password'], PASSWORD_DEFAULT);
    $newUser->avatar = $fileMoved ? $target : null;
    $newUser->contacts = $formData['contacts'];

    $newUser->insert();

    if ($newUser->id) {
        $_SESSION['user'] = ['id' => $newUser->id, 'name' => $newUser->name, 'avatar' => $newUser->avatar];
    }

    header("Location: index.php");
    exit;
}
*/

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Регистрация</title>
    <link href="css/normalize.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>

<?=includeTemplate('templates/header.php', ['avatar' => Auth::getAvatar()]); ?>

<?=includeTemplate('templates/signup_main.php', ['categories' => $categories, 'data' => $form->formData, 'class' => $form->formClasses, 'message' => $form->formMessages]); ?>

<?=includeTemplate('templates/footer.php', ['categories' => $categories]); ?>

</body>
</html>
