<?php
use YetiCave\finders\lotfinder;
use YetiCave\finders\betfinder;

$expiredLots = LotFinder::getExpiredLots();

$file = fopen("winners.txt", "w");

foreach ($expiredLots as $lot) {
    $maxBets = BetFinder::getMaxBetsByLot($lot->id);
    $winner = getWinner($maxBets);
    if ($winner) {
        $lot->winner = $winner->user;
        $lot->update();
        $string = "Победитель по лоту ".$lot->id." - ".$winner->name." (".$winner->email."). Ставка ".$winner->price."\n";
        fwrite($file, $string);
    }
}

fclose($file);

?>
