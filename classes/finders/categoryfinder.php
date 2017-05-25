<?php

/**
 * Class CategoryFinder
 */
class CategoryFinder extends BaseFinder {

    public static function getAll()
    {
        $sql  = 'select id, name, image ';
        $sql .= 'from category ';
        $sql .= 'order by id';

        return parent::select($sql, 'CategoryRecord');
    }

}

?>
