<?php
namespace YetiCave\finders;

use YetiCave\database;
use YetiCave\records\lotrecord;
use YetiCave\records\betrecord;
use YetiCave\records\userrecord;
use YetiCave\records\categoryrecord;

/**
 * Class BaseFinder
 */
class BaseFinder {

    /**
     * Ограничения на количество записей в результате запроса
     */
    public static $ROWS_LIMIT = 9;

    /**
     * Выполняет запрос для получения данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param string $className Название класса
     * @param array $param Значения параметров для условий запроса
     * @return array Массив объектов
     */
    public static function select($sql, $className, array $param = [])
    {
        $result = [];

        $data = DataBase::instance()->getData($sql, $param);

        foreach ($data as $key => $record) {

            switch ($className) {
                case 'LotRecord':
                    $row = new LotRecord();
                    break;
                case 'BetRecord':
                    $row = new BetRecord();
                    break;
                case 'UserRecord':
                    $row = new UserRecord();
                    break;
                case 'CategoryRecord':
                    $row = new CategoryRecord();
                    break;
                default:
                    break;
            }

            foreach ($record as $prop => $value) {
                $row->$prop = $value;
            }
            $result[] = $row;
        }

        return $result;
    }

    /**
     * Выполняет запрос для получения количества записей в таблице lot
     * @param string $type Тип условия запроса
     * @param string $data Параметр условия запроса
     * @return int Количество записей
     */
    public static function getLotsCount($type = '', $data = '')
    {
        $sql = 'select count(*) as count from lot';

        switch ($type) {
            case 'category':
                $sql .= ' where category = ?';
                $param = [$data];
                break;
            case 'search':
                $sql .= ' where name like ? or description like ?';
                $param = ['%'.$data.'%', '%'.$data.'%'];
                break;
            default:
                $param = [];
                break;
        }

        $data = DataBase::instance()->getData($sql, $param);

        return $data[0]['count'];
    }

    /**
     * Возвращает значение свойства $ROWS_LIMIT
     * @return int Значение свойства $ROWS_LIMIT
     */
    public static function getRowsLimit()
    {
        return self::$ROWS_LIMIT;
    }

}

?>
