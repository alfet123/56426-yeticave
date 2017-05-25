<?php

/**
 * Class DataBase синглтон, т.е. его нельзя напрямую создать, а можно лишь обращаться через DataBase::instance()
 */
class DataBase {

    /**
     * @var mysqli $link Установленное подключение
     */
    private $link;

    /**
     * @var mysqli_stmt $stmt Подготовленное выражение
     */
    private $stmt;

    /**
     * Конструктор
     */
    private function __construct()
    {
        global $DBCONFIG;

        $this->link = mysqli_connect($DBCONFIG['host'], $DBCONFIG['user'], $DBCONFIG['pass'], $DBCONFIG['name']);

        if ($this->link) {
            mysqli_query($this->link, "SET NAMES 'utf8'");
            mysqli_query($this->link, "SET CHARACTER SET 'utf8'");
        } else {
            echo "Error connection to database";
            exit;
        }
    }

    /**
     * Деструктор
     */
    public function __destruct()
    {
        mysqli_close($this->link);
    }

    /**
     * Получение экземпляра бд
     */
    public static function instance()
    {
        static $instance;
        if (!$instance) {
            $instance = new DataBase();
        }
        return $instance;
    }

    /**
     * Возвращает информацию о последней ошибке
     * @return string Описание ошибки
     */
    public function lastError()
    {
        return mysqli_error($this->link);
    }

    /**
     * Выполняет запрос для получения данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array $data Значения параметров для условий запроса
     * @return array Массив с данными
     */
    public function getData($sql, $data = [])
    {
        $result = [];

        $this->prepareStmt($sql, $data);

        if ($this->stmt) {

            if (mysqli_stmt_execute($this->stmt)) {

                $res = mysqli_stmt_get_result($this->stmt);

                while ($row = mysqli_fetch_array($res, MYSQLI_ASSOC)) {
                    $result[] = $row;
                }

            }

            mysqli_stmt_close($this->stmt);

        }

        return $result;
    }

    /**
     * Выполняет запрос для добавления данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array $data Значения для добавления
     * @return mixed Идентификатор новой записи
     */
    public function insertData($sql, $data)
    {
        $result = false;

        $this->prepareStmt($sql, $data);

        if ($this->stmt) {

            if (mysqli_stmt_execute($this->stmt)) {
                $result = mysqli_stmt_insert_id($this->stmt);
            }

            mysqli_stmt_close($this->stmt);

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
    public function updateData($table, $data, $conditions)
    {
        $result = false;

        $values = [];

        $sql = "update `".$table."` set ";

        $sql .= self::sqlFragment($data, ", ", $values);

        if (!empty($conditions)) {
            $sql .= " where ".self::sqlFragment($conditions, " and ", $values);
        }

        $this->prepareStmt($sql, $values);

        if ($this->stmt) {

            if (mysqli_stmt_execute($this->stmt)) {
                $result = mysqli_stmt_affected_rows($this->stmt);
            }

            mysqli_stmt_close($this->stmt);

        }

        return $result;
    }

    /**
     * Выполняет запрос для удаления данных
     * @param string $table Название таблицы
     * @param array $conditions Значения параметров для условий запроса
     * @return int Количество удаленных записей
     */
    public function deleteData($table, $conditions)
    {
        $result = false;

        $values = [];

        $sql = "delete from ".$table;

        if (!empty($conditions)) {
            $sql .= " where ".self::sqlFragment($conditions, " and ", $values);
        }

        $this->prepareStmt($sql, $values);

        if ($this->stmt) {

            if (mysqli_stmt_execute($this->stmt)) {
                $result = mysqli_stmt_affected_rows($this->stmt);
            }

            mysqli_stmt_close($this->stmt);

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
     * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
     * @param string $sql SQL запрос с плейсхолдерами вместо значений
     * @param array $data Данные для вставки на место плейсхолдеров
     */
    private function prepareStmt($sql, $data = [])
    {
        $this->stmt = mysqli_prepare($this->link, $sql);

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

            $values = array_merge([$this->stmt, $types], $stmt_data);

            $func = 'mysqli_stmt_bind_param';
            $func(...$values);
        }
    }

}

?>
