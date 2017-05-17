<?php

/**
 * Class User
 */
class User {

    /**
     * Выполняет аутентификацию пользователя
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param string $email E-mail
     * @param string $password Пароль
     * @return array Состояние и данные аутентификации
     */
    public static function login($email, $password)
    {
        if ($user = self::getUserByEmail($email)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return ['auth' => true, 'field' => ''];
            } else {
                return ['auth' => false, 'field' => 'password'];
            }
        }
        return ['auth' => false, 'field' => 'email'];
    }

    /**
     * Удаляет сеанс пользователя
     */
    public static function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Проверяет аутентификацию пользователя
     * @return bool Состояние аутентификации
     */
    public static function isAuth()
    {
        return isset($_SESSION['user']);
    }

    /**
     * Возвращает аватар текущего пользователя
     * @return string Путь к файлу аватара
     */
    public static function getAvatar()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['avatar'])) {
            return $_SESSION['user']['avatar'];
        }
        return 'img/user.jpg';
    }

    /**
     * Возвращает информацию о текущем пользователе
     * @return array Данные о текущем пользователя
     */
    public static function getUserInfo()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        }
        return null;
    }

    /**
     * Добавляет нового пользователя
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param array $userData Данные нового пользователя
     * @return int Идентификатор нового пользователя в базе данных
     */
    public static function newUser(array $userData)
    {
        $values = [];

        $sql  = 'insert into user set ';

        $sql .= DataBase::sqlFragment($userData, ", ", $values);

        return DataBase::instance()->insertData($sql, $values);
    }

    /**
     * Получает пользователя по Id из базы данных
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param int $userId Идентификатор пользователя
     * @return array Данные пользователя
     */
    public static function getUserById($userId)
    {
        $sql = 'select * from `user` where `id` = ?';

        $data = DataBase::instance()->getData($sql, [$userId]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

    /**
     * Получает пользователя по e-mail из базы данных
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param string $email E-mail пользователя
     * @return array Данные пользователя
     */
    public static function getUserByEmail($email)
    {
        $sql = 'select * from `user` where `email` = ? limit 1';

        $data = DataBase::instance()->getData($sql, [$email]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

}

?>
