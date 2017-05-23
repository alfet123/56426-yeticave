<?php

/**
 * Class SignupForm
 */
class SignupForm extends BaseForm {

    /**
     * Данные из формы
     */
    public $formData = [
        'email' => '',
        'password' => '',
        'name' => '',
        'contacts' => ''
    ];

    /**
     * Сообщения о пустых значениях
     */
    public $emptyMessages = [
        'email' => 'Введите e-mail',
        'password' => 'Введите пароль',
        'name' => 'Введите ваше имя',
        'contacts' => 'Введите контактные данные'
    ];

    public function __construct()
    {
        parent::__construct();
    }

}

?>
