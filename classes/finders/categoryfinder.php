<?php

/**
 * Class CategoryFinder
 */
class CategoryFinder extends BaseFinder {

    public static function getAll()
    {
        $sql  = 'select id, name ';
        $sql .= 'from category ';
        $sql .= 'order by id';

        return parent::select($sql, 'CategoryRecord');
    }

}

?>