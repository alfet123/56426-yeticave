<?php
use YetiCave\finders\basefinder;

// функция вычисляет оставшееся время до указанного времени
function timeRemaining($ts)
{
    $now = time();
    if ($ts <= $now ) {
        return "Expire";
    }
    $diff = $ts - $now;
    $days = intval($diff / 86400);
    if ($days) {
        return $days." day".(($days > 1) ? "s" : "");
    }
    return gmdate("H:i", $diff + 60);
}

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

// функция отображает документ
function renderDocument($title, $templates)
{
    echo(includeTemplate('templates/html_begin.php', ['title' => $title]));
    foreach ($templates as $name => $data) {
        echo(includeTemplate('templates/'.$name.'.php', $data));
    }
    echo(includeTemplate('templates/html_end.php', []));
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

// функция расчета параметров для пагинации
function pagesParam($rowsCount)
{
    $pagesCount = ceil($rowsCount / BaseFinder::ROWS_LIMIT);
    $currentPage = (isset($_GET['page']) && is_numeric($_GET['page']) && intval($_GET['page'])>0 && intval($_GET['page'])<=$pagesCount) ? intval($_GET['page']) : 1;
    $offset = ($currentPage - 1) * BaseFinder::ROWS_LIMIT;

    return [
        'count' => $pagesCount,
        'current' => $currentPage,
        'offset' => $offset
    ];
}

// функция определения победителя
function getWinner($bets)
{
    if (!count($bets)) {
        return false;
    }

    $winner = $bets[0];
    foreach ($bets as $bet) {
        if ($bet->price > $winner->price) {
            $winner = $bet;
        }
    }

    return $winner;
}

?>
