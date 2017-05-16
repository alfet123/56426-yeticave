<?php

/**
 * Class Lot
 */
class Lot {

    /**
     * Получает список лотов
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param array $ids Список идентификаторов лотов
     * @return array Список лотов
     */
    public static function getLots($link, array $ids = [])
    {
        $sql  = 'select lot.*, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        if (!empty($ids)) {
            $sql .= 'where lot.id in ('.implode(',', array_fill(0, count($ids), '?')).') ';
        }
        $sql .= 'order by date_create desc';

        return DataBase::getData($link, $sql, $ids);
    }

    /**
     * Получает лот по Id
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param int $lotId Идентификатор лота
     * @return array Данные лота
     */
    public static function getLotById($link, $lotId)
    {
        $data = $this->getLots($link, [$lotId]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    /**
     * Добавляет новый лот
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param array $lotData Данные нового лота
     * @return int Идентификатор нового лота
     */
    public static function newLot($link, array $lotData)
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

        return DataBase::insertData($link, $sql, $lotData);
    }

}

?>
