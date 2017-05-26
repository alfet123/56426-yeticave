<?php
namespace YetiCave\records;

use YetiCave\records\baserecord;

/**
 * Class CategoryRecord
 */
class CategoryRecord extends BaseRecord {

    public $name;

    protected function tableName()
    {
        return 'category';
    }

}

?>
