<?php

/**
 * Class LotFinder
 */
class LotFinder extends BaseFinder {

    /**
     * Получает список лотов
     * @param array $ids Список идентификаторов лотов
     * @return array Список лотов
     */
    public static function getLots(array $ids = [])
    {
        $sql  = 'select lot.*, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        if (!empty($ids)) {
            $sql .= 'where lot.id in ('.implode(',', array_fill(0, count($ids), '?')).') ';
        }
        $sql .= 'order by date_create desc';

        return parent::select($sql, 'LotRecord', $ids);
    }

    /**
     * Получает лот по Id
     * @param int $lotId Идентификатор лота
     * @return array Данные лота
     */
    public static function getLotById($lotId)
    {
        $data = self::getLots([$lotId]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    /**
     * Получает список лотов по категории
     * @param int $catId Идентификатор категории
     * @return array Список лотов
     */
    public static function getLotsByCategory($catId)
    {
        $sql  = 'select lot.*, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        $sql .= 'where lot.category = ? ';
        $sql .= 'order by date_create desc';

        return parent::select($sql, 'LotRecord', [$catId]);
    }

}

?>
