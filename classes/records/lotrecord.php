<?php

/**
 * Class LotRecord
 */
class LotRecord extends BaseRecord {

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

    protected function tableName()
    {
        return 'lot';
    }

}

?>
