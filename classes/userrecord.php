<?php

/**
 * Class UserRecord
 */
class UserRecord extends BaseRecord {

    public $id;
    public $date_reg;
    public $email;
    public $name;
    public $password;
    public $avatar;
    public $contacts;

    /**
     * Добавляет нового пользователя
     */
    public function save()
    {
        $data = [];
        $params = [];

        foreach ($this as $key => $value) {
            if ($value) {
                $data[] = $value;
                $params[] = $key.' = ?';
            }
        }

        $sql  = 'insert into user set ';
        $sql .= implode(', ', $params);

        $this->id = DataBase::instance()->insertData($sql, $data);
    }

}

?>
