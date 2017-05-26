<?php
namespace YetiCave\finders;

use YetiCave\finders\basefinder;

/**
 * Class BetFinder
 */
class BetFinder extends BaseFinder {

    /**
     * Получает список ставок по лоту с сортировкой по убыванию цены
     * @param int $lotId Идентификатор лота
     * @return array Список ставок
     */
    public static function getBetsByLot($lotId)
    {
        $sql  = 'select bet.*, user.id, user.name as user ';
        $sql .= 'from bet ';
        $sql .= 'join user on bet.user = user.id ';
        $sql .= 'where bet.lot = ? ';
        $sql .= 'order by bet.price desc';

        return parent::select($sql, 'BetRecord', [$lotId]);
    }

    /**
     * Получает список ставок по пользователю с сортировкой по убыванию даты
     * @param int $userId Идентификатор пользователя
     * @return array Список ставок
     */
    public static function getBetsByUser($userId)
    {
        $sql  = 'select bet.*, max(bet.price) as price, lot.id, lot.image, lot.name as lot, category.name as category ';
        $sql .= 'from lot ';
        $sql .= 'join category on lot.category = category.id ';
        $sql .= 'join bet on lot.id = bet.lot ';
        $sql .= 'where bet.user = ? ';
        $sql .= 'group by lot.id, bet.id ';
        $sql .= 'order by bet.date desc';

        return parent::select($sql, 'BetRecord', [$userId]);
    }

}

?>
