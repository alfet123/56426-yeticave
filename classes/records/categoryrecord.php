<?php

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
