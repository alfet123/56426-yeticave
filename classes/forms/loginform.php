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

    public function __construct()
    {
        parent::__construct();
    }

}

?>
