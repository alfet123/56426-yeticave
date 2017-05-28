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
        if (!empty($this->formData['price']) && !is_numeric($this->formData['price'])) {
            $this->setFormError('price', 'Введите числовое значение');
        }

        if (!empty($this->formData['step']) && !is_numeric($this->formData['step'])) {
            $this->setFormError('step', 'Введите числовое значение');
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
