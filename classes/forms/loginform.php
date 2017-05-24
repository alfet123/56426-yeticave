<?php

/**
 * Class LoginForm
 */
class LoginForm extends BaseForm {

    /**
     * Данные из формы
     */
    public $formData = [
        'email' => '',
        'password' => ''
    ];

    /**
     * Сообщения о пустых значениях
     */
    public $emptyMessages = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль'
    ];

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

}

?>
