<?php

/**
 * Class LoginForm
 */
class LoginForm extends BaseForm {

    /**
     * Сообщения о неверных значениях
     */
    public $errorAuthMessages = [
        'email' => 'Вы ввели неверный e-mail',
        'password' => 'Вы ввели неверный пароль'
    ];

    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Аутентификация пользователя
     */
    public function userLogin()
    {
        // Проверка, что форма заполнена полностью
        if (empty($this->formClasses['form'])) {

            $user = Auth::login($this->formData['email'], $this->formData['password']);

            if ($user['auth']) {
                header("Location: /");
                exit;
            }

            $this->formData[$user['field']] = '';
            $this->setFormError($user['field'], $this->errorAuthMessages[$user['field']]);

        }
    }

    /**
     * Возвращает названия полей формы
     * @return array Список полей формы
     */
    protected function fieldNames()
    {
        return ['email', 'password'];
    }

    /**
     * Возвращает сообщения о пустых значениях
     * @return array Список сообщений
     */
    protected function emptyMessages()
    {
        return [
            'email' => 'Введите e-mail',
            'password' => 'Введите пароль'
        ];
    }

}

?>
