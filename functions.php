<?php

// функция обеспечивает защиту от XSS
function dataFiltering($data)
{
    if (is_array($data)) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = dataFiltering($value);
        }
    } else {
        $result = htmlspecialchars($data);
    }
    return $result;
}

// функция выводит шаблон из заданного файла
function includeTemplate($file, $data)
{
    if (file_exists($file)) {
        $data = dataFiltering($data);
        extract($data);
        ob_start();
        include($file);
        $result = ob_get_clean();
    } else {
        $result = "";
    }

    return $result;
}

// функция выводит время в относительном формате
function timeInRelativeFormat($ts)
{
    $minutes = (time() - $ts) / 60;
    $hours = $minutes / 60;
    if ($hours > 24) {
        $result = gmdate("d.m.y в H:i", $ts);
    } else if ($minutes > 60) {
        $result = (int) $hours." часов назад";
    } else {
        $result = (int) $minutes." минут назад";
    }
    return $result;
}

// функция установки класса и сообщения при ошибке на форме
function setFormError(&$formClasses, &$formMessages, $field, $message)
{
    $formClasses['form'] = 'form--invalid';
    $formClasses[$field] = 'form__item--invalid';
    $formMessages[$field] = $message;
}

// функция поиска пользователя по e-mail
function searchUserByEmail($email, $users)
{
    $result = null;
    foreach ($users as $user) {
        if ($user['email'] == $email) {
            $result = $user;
            break;
        }
    }
    return $result;
}

// функция определения максимальной ставки
function getMaxBet($bets)
{
    $betPrice = array_map(function($b) { return $b['price']; }, $bets);
    return (count($betPrice)) ? max($betPrice) : 0;
}

// функция проверки аутентификации
function requireAuthentication()
{
    if (!isset($_SESSION['user'])) {
        header("HTTP/1.0 403 Forbidden");
        echo "Доступ запрещен";
        exit;
    }
}

// функция чтения Cookie
function decodeCookie($name)
{
    if (isset($_COOKIE[$name])) {
        $result = json_decode($_COOKIE[$name], true);
    } else {
        $result = [];
    }

    return $result;
}

?>
