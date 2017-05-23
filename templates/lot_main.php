<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $key => $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value->name;?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="lot-item container">
        <h2><?=$lot->name;?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="<?=$lot->image;?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot->category;?></span></p>
                <p class="lot-item__description"><?=$lot->description;?></p>
            </div>
            <div class="lot-item__right">
            <?php if (isset($_SESSION['user']) && $lot_extra['no-bet']): ?>
                <div class="lot-item__state">
                    <div class="lot-item__timer timer">
                        <?=$lot_time_remaining;?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=$lot_extra['curr-bet'];?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=$lot_extra['min-bet'];?> р</span>
                        </div>
                    </div>
                    <form class="lot-item__form" action="lot.php?id=<?=$lot->id;?>" method="post">
                        <div class="lot-item__form-item <?=$class['cost'];?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="<?=$lot_extra['min-bet'];?>"> <!-- number required placeholder="12 000" -->
                            <span class="form__error"><?=$message['cost'];?></span>
                        </div>
                        <button type="submit" class="button" name="send">Сделать ставку</button>
                    </form>
                </div>
            <?php endif; ?>
                <div class="history">
                    <h3>История ставок (<span><?=count($bets);?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($bets as $key => $value): ?>
                        <tr class="history__item">
                            <td class="history__name"><?=$value->user;?></td>
                            <td class="history__price"><?=$value->price;?> р</td>
                            <td class="history__time"><?=timeInRelativeFormat(strtotime($value->date));?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
