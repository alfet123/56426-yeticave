<?php

/**
 * Class Category
 */
class Category {

    /**
     * Получает все категории из базы данных
     * @param DataBase $db Объект для подключения к базе данных
     * @return array Список категорий
     */
    public static function getAll()
    {
        $sql = 'select `id`, `name` from `category` order by `id`';

        return DataBase::instance()->getData($sql, []);
    }

}

?>
