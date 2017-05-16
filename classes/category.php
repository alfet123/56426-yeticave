<?php

/**
 * Class Category
 */
class Category {

    /**
     * Получает все категории из базы данных
     * @param mysqli $link Идентификатор подключения к базе данных
     * @return array Список категорий
     */
    public static function getAll($link)
    {
        $sql = 'select `id`, `name` from `category` order by `id`';

        return DataBase::getData($link, $sql, []);
    }

}

?>
