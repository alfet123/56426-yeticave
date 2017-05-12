<?php

// подключение файла с данными
require_once 'data.php';

// подключение файла с вспомогательной функцией
require_once 'mysql_helper.php';

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

// функция получения аватара
function getAvatar()
{
    if (isset($_SESSION['user']) && !empty($_SESSION['user']['avatar'])) {
        return $_SESSION['user']['avatar'];
    } else {
        return 'img/user.jpg';
    }
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
        header("Location: login.php");
        exit;
    }
}

// функция для получения данных
function getData($link, $sql, $data = [])
{
    $result = [];

    $stmt = db_get_prepare_stmt($link, $sql, $data);

    if ($stmt) {

        if (mysqli_stmt_execute($stmt)) {

            $res = mysqli_stmt_get_result($stmt);

            while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                $result[] = $row;
            }

        }

        mysqli_stmt_close($stmt);

    }

    return $result;
}

// функция для добавления данных
function insertData($link, $sql, $data)
{
    $result = false;

    $stmt = db_get_prepare_stmt($link, $sql, $data);

    if ($stmt) {

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_insert_id($stmt);
        }

        mysqli_stmt_close($stmt);

    }

    return $result;
}

// функция создания фрагмента запроса
function sqlFragment($data, $separator, &$values)
{
    $pairs = [];
    foreach ($data as $key => $value) {
        $pairs[] = "`".$key."` = ?";
        $values[] = $value;
    }
    return implode($separator, $pairs);
}

// функция для обновления данных
function updateData($link, $table, $data, $conditions)
{
    $result = false;

    $values = [];

    $sql = "update `".$table."` set ";

    $sql .= sqlFragment($data, ", ", $values);

    if (!empty($conditions)) {
        $sql .= " where ".sqlFragment($conditions, " and ", $values);
    }

    $stmt = db_get_prepare_stmt($link, $sql, $values);

    if ($stmt) {

        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_affected_rows($stmt);
        }

        mysqli_stmt_close($stmt);

    }

    return $result;
}

// функция для подключения к базе данных
function dbConnect($db)
{
    $link = mysqli_connect($db['host'], $db['name'], $db['user'], $db['pass']);

    if ($link) {
        mysqli_query($link, "SET NAMES 'utf8'");
        mysqli_query($link, "SET CHARACTER SET 'utf8'");
    }

    return $link;
}

// функция получения пользователя по e-mail
function getUserByEmail($link, $email)
{
    $sql = 'select * from `user` where `email` = ? limit 1';

    $data = getData($link, $sql, [$email]);

    if (!empty($data)) {
        return $data[0];
    }

    return null;
}

// функция получения пользователя по Id
function getUserById($link, $userId)
{
    $sql = 'select * from `user` where `id` = ?';

    $data = getData($link, $sql, [$userId]);

    if (!empty($data)) {
        return $data[0];
    }

    return null;
}

// функция получения категорий
function getCategories($link)
{
    $sql = 'select `id`, `name` from `category` order by `id`';

    return getData($link, $sql, []);
}

// функция получения лотов
function getLots($link, array $ids = [])
{
    $sql  = 'select lot.*, category.name as category ';
    $sql .= 'from lot ';
    $sql .= 'join category on lot.category = category.id ';
    if (!empty($ids)) {
        $sql .= 'where lot.id in (?) ';
    }
    $sql .= 'order by date_create desc';

    return getData($link, $sql, $ids);
}

// функция получения лота по Id
function getLotById($link, $lotId)
{
    $data = getLots($link, [$lotId]);

    if (!empty($data)) {
        return $data[0];
    }

    return null;
}

// функция получения списка ставок по лоту с сортировкой по убыванию цены
function getBetsByLot($link, $lotId)
{
    $sql  = 'select bet.date, bet.price, user.id, user.name ';
    $sql .= 'from bet ';
    $sql .= 'join user on bet.user = user.id ';
    $sql .= 'where bet.lot = ? ';
    $sql .= 'order by bet.price desc';

    return getData($link, $sql, [$lotId]);
}

// функция получения списка ставок по пользователю с сортировкой по убыванию даты
function getBetsByUser($link, $userId)
{
    $sql  = 'select lot.id, lot.image, lot.name as name, category.name as category, max(bet.price) as price, bet.date ';
    $sql .= 'from lot ';
    $sql .= 'join category on lot.category = category.id ';
    $sql .= 'join bet on lot.id = bet.lot ';
    $sql .= 'where bet.user = ? ';
    $sql .= 'group by lot.id, bet.id ';
    $sql .= 'order by bet.date desc';

    return getData($link, $sql, [$userId]);
}

// функция добавления лота
function newLot($link, array $lot)
{
    $sql  = 'insert into lot set ';
    $sql .= 'date_create = ?, ';
    $sql .= 'name = ?, ';
    $sql .= 'description = ?, ';
    $sql .= 'image = ?, ';
    $sql .= 'price = ?, ';
    $sql .= 'date_expire = ?, ';
    $sql .= 'step = ?, ';
    $sql .= 'owner = ?, ';
    $sql .= 'category = ?';

    return insertData($link, $sql, $lot);
}

// функция добавления ставки
function newBet($link, array $bet)
{
    $sql  = 'insert into bet set ';
    $sql .= 'date = ?, ';
    $sql .= 'price = ?, ';
    $sql .= 'user = ?, ';
    $sql .= 'lot = ?';

    return insertData($link, $sql, $bet);
}

// функция добавления пользователя
function newUser($link, array $userData)
{
    $values = [];

    $sql  = 'insert into user set ';

    $sql .= sqlFragment($userData, ", ", $values);

    return insertData($link, $sql, $values);
}

?>
