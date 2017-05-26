<?php
namespace YetiCave\forms;

use YetiCave\forms\baseform;
use YetiCave\records\betrecord;

/**
 * Class LotForm
 */
class LotForm extends BaseForm {

    /**
     * Дополнительные данные
     */
    public $extraData = [
        'curr-bet' => '',
        'min-bet' => '',
        'no-bet' => true
    ];

    /**
     * Конструктор
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Инициализация дополнительных данных
     * @param object $lot Текущий лот
     * @param array $bets Список ставок
     */
    public function initExtraData($lot, $bets)
    {
        $this->extraData['curr-bet'] = (count($bets)) ? getMaxBet($bets) : $lot->price;
        $this->extraData['min-bet'] = $this->extraData['curr-bet'] + ((count($bets)) ? $lot->step : 0);

        // Если открыт сеанс и есть ставки, проверка кто сделал последнюю ставку
        if (isset($_SESSION['user']) && count($bets)) {
            if (($_SESSION['user']['id'] == $bets[0]->id)) {
                $this->extraData['no-bet'] = false;
            }
        }
    }

    /**
     * Проверка значения введенной ставки
     */
    public function checkBetValue()
    {
        if (empty($this->formData['cost'])) {
            return;
        }

        if (!is_numeric($this->formData['cost'])) {
            $this->setFormError('cost', 'Введите числовое значение');
        } elseif ($this->formData['cost'] < $this->extraData['min-bet']) {
            $this->setFormError('cost', 'Минимальная ставка '.$this->extraData['min-bet']);
        }
    }

    /**
     * Сохранение новой ставки
     * @param int Идентификатор лота
     */
    public function saveNewBet($lotId)
    {
        // Проверка, что форма заполнена полностью
        if (empty($this->formClasses['form'])) {
            $newBet = new BetRecord();

            $newBet->date = date("Y-m-d H:i:s");
            $newBet->price = $this->formData['cost'];
            $newBet->user = $_SESSION['user']['id'];
            $newBet->lot = $lotId;

            $newBet->insert();

            header("Location: mylots.php");
            exit;
        }
    }

    /**
     * Возвращает названия полей формы
     * @return array Список полей формы
     */
    protected function fieldNames()
    {
        return ['cost'];
    }

    /**
     * Возвращает сообщения о пустых значениях
     * @return array Список сообщений
     */
    protected function emptyMessages()
    {
        return [
            'cost' => 'Введите ставку'
        ];
    }

}

?>
