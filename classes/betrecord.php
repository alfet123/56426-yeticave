<?php

/**
 * Class BetRecord
 */
class BetRecord extends BaseRecord {

    public $id;
    public $date;
    public $price;
    public $user;
    public $lot;
    public $category;
    public $image;

    /**
     * Добавляет новую ставку
     */
    public function save()
    {
        $sql  = 'insert into bet set ';
        $sql .= 'date = ?, ';
        $sql .= 'price = ?, ';
        $sql .= 'user = ?, ';
        $sql .= 'lot = ?';

        $data = [
            $this->date,
            $this->price,
            $this->user,
            $this->lot
        ];

        $this->id = DataBase::instance()->insertData($sql, $data);
    }

}

?>
