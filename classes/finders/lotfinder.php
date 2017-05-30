<?php
namespace YetiCave\finders;

use YetiCave\finders\basefinder;

/**
 * Class LotFinder
 */
class LotFinder extends BaseFinder {

    /**
     * Получает список лотов
     * @param array $ids Список идентификаторов лотов
     * @return array Список лотов
     */
    public static function getLots(array $ids = [], $offset = 0)
    {
        $sql  = 'select lot.*, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        if (!empty($ids)) {
            $sql .= 'where lot.id in ('.implode(',', array_fill(0, count($ids), '?')).') ';
        }
        $sql .= 'order by date_create desc ';
        $sql .= 'limit ? offset ?';

        return parent::select($sql, 'LotRecord', array_merge($ids, [parent::ROWS_LIMIT, $offset]));
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
    public static function getLotsByCategory($catId, $offset = 0)
    {
        $sql  = 'select lot.*, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        $sql .= 'where lot.category = ? ';
        $sql .= 'order by date_create desc ';
        $sql .= 'limit ? offset ?';

        return parent::select($sql, 'LotRecord', [$catId, parent::ROWS_LIMIT, $offset]);
    }

    /**
     * Получает список лотов по поисковой строке
     * @param string $searchString Поисковая строка
     * @return array Список лотов
     */
    public static function getLotsBySearchString($searchString, $offset = 0)
    {
        $sql  = 'select lot.*, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        $sql .= 'where lot.name like ? or lot.description like ? ';
        $sql .= 'order by date_create desc ';
        $sql .= 'limit ? offset ?';

        return parent::select($sql, 'LotRecord', ['%'.$searchString.'%', '%'.$searchString.'%', parent::ROWS_LIMIT, $offset]);
    }

    /**
     * Получает список лотов без победителей с истекшей датой
     * @return array Список лотов
     */
    public static function getExpiredLots()
    {
        $sql  = 'select lot.* ';
        $sql .= 'from lot ';
        $sql .= 'where lot.winner is null and lot.date_expire <= ?';

        return parent::select($sql, 'LotRecord', [date('Y-m-d H:i:s')]);
    }

}

?>
