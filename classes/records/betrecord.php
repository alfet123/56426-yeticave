<?php

/**
 * Class BetRecord
 */
class BetRecord extends BaseRecord {

    public $date;
    public $price;
    public $user;
    public $lot;
    public $category;
    public $image;

    protected function tableName()
    {
        return 'bet';
    }

}

?>
