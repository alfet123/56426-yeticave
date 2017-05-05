<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $key => $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value;?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($bets as $key => $value): ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../<?=$lots[$value['id']]['image'];?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?=$value['id'];?>"><?=$lots[$value['id']]['name'];?></a></h3>
                </td>
                <td class="rates__category">
                    <?=$lots[$value['id']]['category'];?>
                </td>
                <td class="rates__timer">
                    <div class="timer timer--finishing"><?=$lot_time_remaining;?></div>
                </td>
                <td class="rates__price">
                    <?=$value['cost'];?>
                </td>
                <td class="rates__time">
                    <?=timeInRelativeFormat($value['ts']);?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
