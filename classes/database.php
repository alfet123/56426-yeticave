<?php

/**
 * Class DataBase
 */
class DataBase {

    /**
     * @var mysqli $link Установленное подключение
     */
    private static $link;

    /**
     * @var mysqli_stmt $stmt Подготовленное выражение
     */
    private static $stmt;

    /**
     * Конструктор
     * @param array $config Параметры для установки соединения
     */
    public function __construct($config)
    {
        self::connect($config);
    }

    /**
     * Деструктор
     */
    public function __destruct()
    {
        self::close();
    }

    /**
     * Закрывает подключение к базе данных
     */
    public static function close()
    {
        mysqli_close(self::$link);
    }

    /**
     * Возвращает информацию о последней ошибке
     * @return string Описание ошибки
     */
    public static function lastError()
    {
        return mysqli_error(self::$link);
    }

    /**
     * Выполняет запрос для получения данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array $data Значения параметров для условий запроса
     * @return array Массив с данными
     */
    public static function getData($sql, $data = [])
    {
        $result = [];

        self::prepareStmt($sql, $data);

        if (self::$stmt) {

            if (mysqli_stmt_execute(self::$stmt)) {

                $res = mysqli_stmt_get_result(self::$stmt);

                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    $result[] = $row;
                }

            }

            mysqli_stmt_close(self::$stmt);

        }

        return $result;
    }

    /**
     * Выполняет запрос для добавления данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array $data Значения для добавления
     * @return mixed Идентификатор новой записи
     */
    public static function insertData($sql, $data)
    {
        $result = false;

        self::prepareStmt($sql, $data);

        if (self::$stmt) {

            if (mysqli_stmt_execute(self::$stmt)) {
                $result = mysqli_stmt_insert_id(self::$stmt);
            }

            mysqli_stmt_close(self::$stmt);

        }

        return $result;
    }

    /**
     * Выполняет запрос для обновления данных
     * @param string $table Название таблицы
     * @param array $data Новые значения для записи
     * @param array $conditions Значения параметров для условий запроса
     * @return int Количество измененных записей
     */
    public static function updateData($table, $data, $conditions)
    {
        $result = false;

        $values = [];

        $sql = "update `".$table."` set ";

        $sql .= self::sqlFragment($data, ", ", $values);

        if (!empty($conditions)) {
            $sql .= " where ".self::sqlFragment($conditions, " and ", $values);
        }

        self::prepareStmt($sql, $values);

        if (self::$stmt) {

            if (mysqli_stmt_execute(self::$stmt)) {
                $result = mysqli_stmt_affected_rows(self::$stmt);
            }

            mysqli_stmt_close(self::$stmt);

        }

        return $result;
    }

    /**
     * Создает фрагмент запроса с плейсхолдерами
     * @param array $data Ассоциативный массив с исходными данными
     * @param string $separator Строка-разделитель
     * @param array &$values Массив для значений параметров фрагмента запроса
     * @return string Фрагмента запроса в виде строки с плейсхолдерами
     */
    public static function sqlFragment($data, $separator, &$values)
    {
        $pairs = [];
        foreach ($data as $key => $value) {
            $pairs[] = "`".$key."` = ?";
            $values[] = $value;
        }
        return implode($separator, $pairs);
    }

    /**
     * Создает подключение к базе данных
     * @param array $config Параметры для установки соединения
     */
    public static function connect($config)
    {
        self::$link = mysqli_connect($config['host'], $config['user'], $config['pass'], $config['name']);

        if (self::$link) {
            mysqli_query(self::$link, "SET NAMES 'utf8'");
            mysqli_query(self::$link, "SET CHARACTER SET 'utf8'");
        }
    }

    /**
     * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array $data Данные для вставки на место плейсхолдеров
     */
    private static function prepareStmt($sql, $data = [])
    {
        self::$stmt = mysqli_prepare(self::$link, $sql);

        if ($data) {
            $types = '';
            $stmt_data = [];

            foreach ($data as $value) {
                $type = null;

                if (is_int($value)) {
                    $type = 'd';
                }
                else if (is_string($value)) {
                    $type = 's';
                }
                else if (is_double($value)) {
                    $type = 'd';
                }

                if ($type) {
                    $types .= $type;
                    $stmt_data[] = $value;
                }
            }

            $values = array_merge([self::$stmt, $types], $stmt_data);

            $func = 'mysqli_stmt_bind_param';
            $func(...$values);
        }
    }

}

?>
