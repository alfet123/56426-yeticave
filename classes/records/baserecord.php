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

    /**
     * Обновляет запись с указанным id
     */
    public function update()
    {
        $data = [];

        foreach ($this as $key => $value) {
            if ($key != 'id' && $value) {
                $data[$key] = $value;
            }
        }

        return DataBase::instance()->updateData($this->tableName(), $data, ['id' => $this->id]);
    }

    /**
     * Удаляет запись с указанным id
     */
    public function delete()
    {
        return DataBase::instance()->deleteData($this->tableName(), ['id' => $this->id]);
    }

    abstract protected function tableName();

}

?>
