<?php

/**
 * Class LotForm
 */
class LotForm extends BaseForm {

    /**
     * Данные из формы
     */
    public $formData = [
        'cost' => ''
    ];

    /**
     * Сообщения о пустых значениях
     */
    public $emptyMessages = [
        'cost' => 'Введите ставку'
    ];

    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
    }

}

?>
