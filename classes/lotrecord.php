<?php

/**
 * Class LotRecord
 */
class LotRecord extends BaseRecord {

    private $id;
    private $date_create;
    private $name;
    private $description;
    private $image;
    private $price;
    private $date_expire;
    private $step;
    private $owner;
    private $winner;
    private $category;

    public static $tableName = 'lot';

}

?>
