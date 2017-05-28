<?php
namespace YetiCave\forms;

use YetiCave\forms\baseform;
use YetiCave\records\lotrecord;

/**
 * Class AddForm
 */
class AddForm extends BaseForm {

    /**
     * Расположение загруженного файла
     */
    public $target;

    /**
     * Список числовых полей, требующих проверки
     */
    public $numberFields = ['price', 'step'];

    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Проверка корректности числовых полей
     */
    public function checkNumberFields()
    {
        foreach ($this->numberFields as $field) {
            if (strlen($this->formData[$field])) {
                if (!is_numeric($this->formData[$field])) {
                    $this->setFormError($field, 'Введите числовое значение');
                } elseif ($this->formData[$field] <= 0) {
                    $this->setFormError($field, 'Введите положительное число');
                }
            }
        }
    }

    /**
     * Проверка корректности даты завершения
     */
    public function checkDateExpire()
    {
        if (strlen($this->formData['date_expire'])) {
            $time = strtotime($this->formData['date_expire']);
            if ($time) {
                $date = date_parse($this->formData['date_expire']);
                if (checkdate($date['month'], $date['day'], $date['year'])) {
                    $now = getdate();
                    $currentDate = strtotime($now['mday'].".".$now['month'].".".$now['year']);
                    $expireDate = strtotime($date['day'].".".$date['month'].".". $date['year']);
                    if (($expireDate-$currentDate)/86400 < 1) {
                        $this->setFormError('date_expire', 'Укажите дату не раньше '.date('d.m.Y', strtotime('+1 day')));
                    }
                } else {
                    $this->setFormError('date_expire', 'Недопустимое значение даты');
                }
            } else {
                $this->setFormError('date_expire', 'Недопустимый формат даты');
            }
        }
    }

    /**
     * Сохранение загруженного изображения лота
     */
    public function saveLotImage()
    {
        $file = $_FILES['image'];
        $filename = $file['name'];
        if (empty($filename)) {
            $this->setFormError('image', 'Выберите файл для загрузки');
        } else {
            $source = $file['tmp_name'];
            if (BaseForm::isImage($source)) {
                $this->target = "img/$filename";
                if (move_uploaded_file($source, $this->target)) {
                    $this->formData['image'] = $this->target;
                    $this->formClasses['image'] = 'form__item--uploaded';
                } else {
                    $this->setFormError('image', 'Ошибка при загрузке файла');
                }
            } else {
                $this->setFormError('image', 'Файл не является изображением');
            }
        }
    }

    /**
     * Сохранение нового лота
     */
    public function saveNewLot()
    {
        // Проверка, что форма заполнена полностью
        if (empty($this->formClasses['form'])) {
            $now = getdate();

            $newLot = new LotRecord();

            $newLot->date_create = date("Y-m-d H:i:s");
            $newLot->name = $this->formData['name'];
            $newLot->description = $this->formData['description'];
            $newLot->image = $this->target;
            $newLot->price = $this->formData['price'];
            $newLot->date_expire = date("Y-m-d H:i:s", strtotime($this->formData['date_expire']." ".$now['hours'].":".$now['minutes'].":".$now['seconds']));
            $newLot->step = $this->formData['step'];
            $newLot->owner = $_SESSION['user']['id'];
            $newLot->category = $this->formData['category'];

            $newLot->insert();

            header("Location: lot.php?id=".$newLot->id);
            exit;
        }
    }

    /**
     * Возвращает названия полей формы
     * @return array Список полей формы
     */
    protected function fieldNames()
    {
        return ['name', 'category', 'description', 'price', 'step', 'date_expire'];
    }

    /**
     * Возвращает сообщения о пустых значениях
     * @return array Список сообщений
     */
    protected function emptyMessages()
    {
        return [
            'name' => 'Введите название лота',
            'category' => 'Выберите категорию',
            'description' => 'Введите описание лота',
            'price' => 'Введите начальную стоимость',
            'step' => 'Введите шаг ставки',
            'date_expire' => 'Введите дату окончания'
        ];
    }

}

?>
