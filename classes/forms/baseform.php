<?php
namespace YetiCave\forms;

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
    public $errorMessages = [];

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
        $messages = $this->emptyMessages();
        foreach ($this->fieldNames() as $key) {
            $this->formData[$key] = $_POST[$key];
            if (empty($this->formData[$key]) && isset($messages[$key])) {
                $this->setFormError($key, $messages[$key]);
            }
        }
    }

    /**
     * Начальная инициализация
     */
    protected function init()
    {
        foreach ($this->fieldNames() as $key) {
            $this->formData[$key] = '';
            $this->formClasses[$key] = '';
            $this->errorMessages[$key] = '';
        }
        $this->formClasses['form'] = '';
    }

    /**
     * Установка класса и сообщения при ошибке на форме
     * @param string $field Название поля
     * @param string $message Текст сообщения
     */
    protected function setFormError($field, $message)
    {
        $this->formClasses['form'] = 'form--invalid';
        $this->formClasses[$field] = 'form__item--invalid';
        $this->errorMessages[$field] = $message;
    }

    /**
     * Возвращает названия полей формы
     * @return array Список полей формы
     */
    abstract protected function fieldNames();

    /**
     * Возвращает сообщения о пустых значениях
     * @return array Список сообщений
     */
    abstract protected function emptyMessages();

}

?>
