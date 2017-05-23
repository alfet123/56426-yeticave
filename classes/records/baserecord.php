<?php

/**
 * Class BaseRecord
 */
abstract class BaseRecord {

    public $id;

    /**
     * Добавляет новую запись
     */
    public function insert()
    {
        $data = [];
        $params = [];

        foreach ($this as $key => $value) {
            if ($value) {
                $data[] = $value;
                $params[] = $key.' = ?';
            }
        }

        $sql  = 'insert into '.$this->tableName().' set ';
        $sql .= implode(', ', $params);

        $this->id = DataBase::instance()->insertData($sql, $data);
    }

    protected function tableName()
    {

    }

}

?>
