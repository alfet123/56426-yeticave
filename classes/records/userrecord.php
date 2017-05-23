<?php

/**
 * Class UserRecord
 */
class UserRecord extends BaseRecord {

    public $date_reg;
    public $email;
    public $name;
    public $password;
    public $avatar;
    public $contacts;

    protected function tableName()
    {
        return 'user';
    }

}

?>
