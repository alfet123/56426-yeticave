<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <?php foreach ($categories as $key => $value): ?>
            <li class="promo__item">
                <a class="promo__link" style="background-image: url('<?=$value->image;?>')" href="index.php?category=<?=$value->id;?>"><?=$value->name;?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты<?=$title_addon;?></h2>
            <select class="lots__select">
                <option>Все категории</option>
                <?php foreach ($categories as $key => $value): ?>
                    <option value="<?=$value->id;?>"><?=$value->name;?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <ul class="lots__list">
            <?php foreach ($lots as $key => $value): ?>
            <li class="lots__item lot">
                <div class="lot__image">
                    <img src="<?=$value->image;?>" width="350" height="260" alt="Сноуборд">
                </div>
                <div class="lot__info">
                    <span class="lot__category"><?=$value->category;?></span>
                    <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$value->id;?>"><?=$value->name;?></a></h3>
                    <div class="lot__state">
                        <div class="lot__rate">
                            <span class="lot__amount">Стартовая цена</span>
                            <span class="lot__cost"><?=$value->price;?><b class="rub">р</b></span>
                        </div>
                        <div class="lot__timer timer<?=(timeRemaining(strtotime($value->date_expire))) == 'Expire' ? ' timer--finishing' : '';?>">
                            <?=timeRemaining(strtotime($value->date_expire));?>
                        </div>
                    </div>
                </div>
            </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <?php if (isset($page)): ?>
    <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a<?=$page['prev'] ? ' href="?'.$page['param'].'page='.$page['prev'].'"' : ' style="display: none"';?>>Назад</a></li>
        <?php for ($i = 1; $i <= $page['count']; $i++): ?>
            <li class="pagination-item<?=($page['current']==$i) ? ' pagination-item-active' : '';?>"><a<?=($page['current']!=$i) ? ' href="?'.$page['param'].'page='.$i.'"' : '';?>><?=$i;?></a></li>
        <?php endfor; ?>
        <li class="pagination-item pagination-item-next"><a<?=$page['next'] ? ' href="?'.$page['param'].'page='.$page['next'].'"' : ' style="display: none"';?>>Вперед</a></li>
    </ul>
    <?php endif; ?>
</main>
