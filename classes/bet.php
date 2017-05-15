<?php

/**
 * Class Bet
 */
class Bet {

    /**
     * Получает список ставок по лоту с сортировкой по убыванию цены
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param int $lotId Идентификатор лота
     * @return array Список ставок
     */
    public function getBetsByLot($link, $lotId)
    {
        $sql  = 'select bet.date, bet.price, user.id, user.name ';
        $sql .= 'from bet ';
        $sql .= 'join user on bet.user = user.id ';
        $sql .= 'where bet.lot = ? ';
        $sql .= 'order by bet.price desc';

        return DataBase::getData($link, $sql, [$lotId]);
    }

    /**
     * Получает список ставок по пользователю с сортировкой по убыванию даты
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param int $userId Идентификатор пользователя
     * @return array Список ставок
     */
    public function getBetsByUser($link, $userId)
    {
        $sql  = 'select lot.id, lot.image, lot.name as name, category.name as category, max(bet.price) as price, bet.date ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        $sql .= 'join bet on lot.id = bet.lot ';
        $sql .= 'where bet.user = ? ';
        $sql .= 'group by lot.id, bet.id ';
        $sql .= 'order by bet.date desc';

        return DataBase::getData($link, $sql, [$userId]);
    }

    /**
     * Добавляет новую ставку
     * @param mysqli $link Идентификатор подключения к базе данных
     * @param array $betData Данные новой ставки
     * @return int Идентификатор новой ставки
     */
    public function newBet($link, array $betData)
    {
        $sql  = 'insert into bet set ';
        $sql .= 'date = ?, ';
        $sql .= 'price = ?, ';
        $sql .= 'user = ?, ';
        $sql .= 'lot = ?';

        return DataBase::insertData($link, $sql, $betData);
    }

}

?>
