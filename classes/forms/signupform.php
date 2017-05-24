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

    /**
     * Признак корректно загруженного файла
     */
    public $fileMoved;

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
     * Проверка корректности и существования e-mail
     */
    public function checkEmail()
    {
        if (!empty($this->formData['email']) && !filter_var($this->formData['email'], FILTER_VALIDATE_EMAIL)) {
            $this->setFormError('email', 'Введите правильный e-mail');
        }

        if (UserFinder::getUserByEmail($this->formData['email'])) {
            $this->setFormError('email', 'Пользователь с указанным e-mail уже существует');
        }
    }

    /**
     * Сохранение загруженного файла аватара
     */
    public function saveAvatar()
    {
        if (isset($_FILES['avatar'])) {
            $file = $_FILES['avatar'];
            $filename = $file['name'];
            $source = $file['tmp_name'];
            $this->target = "img/$filename";
            $this->fileMoved = move_uploaded_file($source, $this->target);
        }
    }

    /**
     * Сохранение нового пользователя
     */
    public function saveNewUser()
    {
        // Проверка, что форма заполнена полностью
        if (empty($this->formClasses['form'])) {
            $newUser = new UserRecord();

            $newUser->date_reg = date("Y-m-d H:i:s");
            $newUser->email = $this->formData['email'];
            $newUser->name = $this->formData['name'];
            $newUser->password = password_hash($this->formData['password'], PASSWORD_DEFAULT);
            $newUser->avatar = $this->fileMoved ? $this->target : null;
            $newUser->contacts = $this->formData['contacts'];

            $newUser->insert();

            if ($newUser->id) {
                $_SESSION['user'] = ['id' => $newUser->id, 'name' => $newUser->name, 'avatar' => $newUser->avatar];
            }

            header("Location: index.php");
            exit;
        }
    }

}

?>
