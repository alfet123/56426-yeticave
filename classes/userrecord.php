<?php

/**
 * Class UserRecord
 */
class UserRecord extends BaseRecord {

    private $id;
    private $date_reg;
    private $email;
    private $name;
    private $password;
    private $avatar;
    private $contacts;

    public static $tableName = 'user';

}

?>
