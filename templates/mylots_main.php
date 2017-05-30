<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $key => $value): ?>
            <li class="nav__item">
                <a href="index.php?category=<?=$value->id;?>"><?=$value->name;?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">
            <?php foreach ($mybets as $key => $value): ?>
            <tr class="rates__item">
                <td class="rates__info">
                    <div class="rates__img">
                        <img src="../<?=$value->image;?>" width="54" height="40" alt="Сноуборд">
                    </div>
                    <h3 class="rates__title"><a href="lot.php?id=<?=$value->id;?>"><?=$value->name;?></a></h3>
                </td>
                <td class="rates__category">
                    <?=$value->category;?>
                </td>
                <td class="rates__timer">
                    <div class="timer<?=(timeRemaining(strtotime($value->date_expire))) == 'Expire' ? ' timer--finishing' : '';?>"><?=timeRemaining(strtotime($value->date_expire));?></div>
                </td>
                <td class="rates__price">
                    <?=$value->price;?>
                </td>
                <td class="rates__time">
                    <?=timeInRelativeFormat(strtotime($value->date));?>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
