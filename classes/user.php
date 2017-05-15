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
    public function login($link, $email, $password)
    {
        if ($user = $this->getUserByEmail($link, $email)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user'] = $user;
                return ['auth' => true, 'data' => $user];
            } else {
                return ['auth' => false, 'data' => 'password'];
            }
        } else {
            return ['auth' => false, 'data' => 'email'];
        }
    }

    /**
     * Удаляет сеанс пользователя
     */
    public function logout()
    {
        session_unset();
        session_destroy();
    }

    /**
     * Проверяет аутентификацию пользователя
     * @return bool Состояние аутентификации
     */
    public function isAuth()
    {
        if (isset($_SESSION['user'])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Возвращает аватар текущего пользователя
     * @return string Путь к файлу аватара
     */
    public function getAvatar()
    {
        if (isset($_SESSION['user']) && !empty($_SESSION['user']['avatar'])) {
            return $_SESSION['user']['avatar'];
        } else {
            return 'img/user.jpg';
        }
    }

    /**
     * Возвращает информацию о текущем пользователе
     * @return array Данные о текущем пользователя
     */
    public function getUserInfo()
    {
        if (isset($_SESSION['user'])) {
            return $_SESSION['user'];
        } else {
            return null;
        }
    }

    /**
     * Добавляет нового пользователя
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param array $userData Данные нового пользователя
     * @return int Идентификатор нового пользователя в базе данных
     */
    public function newUser($link, array $userData)
    {
        $values = [];

        $sql  = 'insert into user set ';

        $sql .= DataBase::sqlFragment($userData, ", ", $values);

        return DataBase::insertData($link, $sql, $values);
    }

    /**
     * Получает пользователя по Id из базы данных
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param int $userId Идентификатор пользователя
     * @return array Данные пользователя
     */
    public function getUserById($link, $userId)
    {
        $sql = 'select * from `user` where `id` = ?';

        $data = DataBase::getData($link, $sql, [$userId]);

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
    private function getUserByEmail($link, $email)
    {
        $sql = 'select * from `user` where `email` = ? limit 1';

        $data = DataBase::getData($link, $sql, [$email]);

        if (!empty($data)) {
            return $data[0];
        }

        return null;
    }

}

?>
