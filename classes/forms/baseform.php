<?php

/**
 * Class BaseForm
 */
abstract class BaseForm {

    /**
     * Данные из формы
     */
    public $formData = [];

    /**
     * Дополнительные классы
     */
    public $formClasses = [];

    /**
     * Сообщения об ошибке
     */
    public $formMessages = [];

    /**
     * Сообщения о пустых значениях
     */
    public $emptyMessages = [];

    /**
     * Конструктор
     */
    public function __construct()
    {
        $this->init();
    }

    /**
     * Проверка пустых значений
     */
    public function checkEmpty()
    {
        foreach ($this->emptyMessages as $key => $value) {
            if (empty($_POST[$key])) {
                $this->setFormError($key, $value);
            } else {
                $this->formData[$key] = $_POST[$key];
            }
        }
    }

    /**
     * Начальная инициализация
     */
    protected function init()
    {
        $this->formClasses['form'] = '';
        foreach ($this->formData as $key => $value) {
            $this->formClasses[$key] = '';
            $this->formMessages[$key] = '';
        }
    }

    /**
     * Установка класса и сообщения при ошибке на форме
     */
    protected function setFormError($field, $message)
    {
        $this->formClasses['form'] = 'form--invalid';
        $this->formClasses[$field] = 'form__item--invalid';
        $this->formMessages[$field] = $message;
    }

}

?>
