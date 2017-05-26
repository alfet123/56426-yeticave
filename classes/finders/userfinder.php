<?php
namespace YetiCave\finders;

use YetiCave\finders\basefinder;

/**
 * Class UserFinder
 */
class UserFinder extends BaseFinder {

    /**
     * Получает пользователя по Id из базы данных
     * @param int $userId Идентификатор пользователя
     * @return array Данные пользователя
     */
    public static function getUserById($userId)
    {
        $sql = 'select * from user where id = ?';

        $data = parent::select($sql, 'UserRecord', [$userId]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    /**
     * Получает пользователя по e-mail из базы данных
     * @param string $email E-mail пользователя
     * @return array Данные пользователя
     */
    public static function getUserByEmail($email)
    {
        $sql = 'select * from user where email = ? limit 1';

        $data = parent::select($sql, 'UserRecord', [$email]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

}

?>
