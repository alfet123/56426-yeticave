<?php

/**
 * Class User
 */
class User {

    /**
     * Выполняет аутентификацию пользователя
     * @param array $user Данные пользователя
     */
    public function login($user)
    {
        $_SESSION['user'] = $user;
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

}

?>
