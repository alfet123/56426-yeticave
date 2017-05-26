<?php
namespace YetiCave\records;

use YetiCave\records\baserecord;

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
