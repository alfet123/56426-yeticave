<?php

// подключение файла с данными
require_once 'data.php';

// функция обеспечивает защиту от XSS
function dataFiltering($data)
{
    if (is_array($data)) {
        $result = [];
        foreach ($data as $key => $value) {
            $result[$key] = dataFiltering($value);
        }
    } elseif (is_object($data)) {
        foreach ($data as $key => $value) {
            $data->$key = dataFiltering($value);
        }
        return $data;
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

// функция определения максимальной ставки
function getMaxBet($bets)
{
    $betPrice = array_map(function($b) { return $b->price; }, $bets);
    return (count($betPrice)) ? max($betPrice) : 0;
}

?>
