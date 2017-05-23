<?php

/**
 * Class BaseFinder
 */
class BaseFinder {

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
            $row = new $className();
            foreach ($record as $prop => $value) {
                $row->$prop = $value;
            }
            $result[] = $row;
        }

        return $result;
    }

}

?>
