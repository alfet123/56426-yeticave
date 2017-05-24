<?php

/**
 * Class AddForm
 */
class AddForm extends BaseForm {

    /**
     * Данные из формы
     */
    public $formData = [
        'name' => '',
        'category' => '',
        'description' => '',
        'price' => '',
        'step' => '',
        'date_expire' => ''
    ];

    /**
     * Сообщения о пустых значениях
     */
    public $emptyMessages = [
        'name' => 'Введите название лота',
        'category' => 'Выберите категорию',
        'description' => 'Введите описание лота',
        'price' => 'Введите начальную стоимость',
        'step' => 'Введите шаг ставки',
        'date_expire' => 'Введите дату окончания'
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
