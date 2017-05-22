<?php

/**
 * Class LotRecord
 */
class LotRecord extends BaseRecord {

    public $id;
    public $date_create;
    public $name;
    public $description;
    public $image;
    public $price;
    public $date_expire;
    public $step;
    public $owner;
    public $winner;
    public $category;

    /**
     * Добавляет новый лот
     */
    public function save()
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

        $data = [
            $this->date_create,
            $this->name,
            $this->description,
            $this->image,
            $this->price,
            $this->date_expire,
            $this->step,
            $this->owner,
            $this->category
        ];

        $this->id = DataBase::instance()->insertData($sql, $data);
    }

}

?>
