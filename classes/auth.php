<?php

/**
 * Class Auth
 */
class Auth {

    /**
     * Выполняет аутентификацию пользователя
     * @param string $email E-mail
     * @param string $password Пароль
     * @return array Состояние и данные аутентификации
     */
    public static function login($email, $password)
    {
        if ($user = UserFinder::getUserByEmail($email)) {
            if (password_verify($password, $user->password)) {
                $_SESSION['user'] = ['id' => $user->id, 'name' => $user->name, 'avatar' => $user->avatar];
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

}

?>
