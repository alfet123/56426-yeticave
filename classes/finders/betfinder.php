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
        $sql  = 'select bet.user, max(bet.price) as price, max(bet.date) as date, lot.id, lot.image, lot.name, lot.date_expire, category.name as category ';
        $sql .= 'from bet ';
        $sql .= 'join lot on bet.lot = lot.id ';
        $sql .= 'join category on lot.category = category.id ';
        $sql .= 'where bet.user = ? ';
        $sql .= 'group by bet.user, lot.id ';
        $sql .= 'order by date desc';

        return parent::select($sql, 'BetRecord', [$userId]);
    }

    /**
     * Получает последную (максимальную) ставку по лоту для каждого пользователя
     * @param int $lotId Идентификатор лота
     * @return array Список максимальных ставок для каждого пользователя
     */
    public static function getMaxBetsByLot($lotId)
    {
        $sql  = 'select bet.user, max(bet.price) as price, user.name, user.email ';
        $sql .= 'from bet ';
        $sql .= 'join user on bet.user = user.id ';
        $sql .= 'where bet.lot = ? ';
        $sql .= 'group by bet.user';

        return parent::select($sql, 'BetRecord', [$lotId]);
    }

}

?>
