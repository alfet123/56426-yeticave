<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $key => $value): ?>
            <li class="nav__item">
                <a href="all-lots.html"><?=$value['name'];?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form form--add-lot container <?=$class['form'];?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?=$class['name'];?>"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="name" value="<?=$data['name'];?>" placeholder="Введите наименование лота"> <!-- required -->
                <span class="form__error"><?=$message['name'];?></span>
            </div>
            <div class="form__item <?=$class['category'];?>">
                <label for="category">Категория</label>
                <select id="category" name="category"> <!-- required -->
                    <option value="0">Выберите категорию</option>
                    <?php foreach ($categories as $key => $value): ?>
                        <option value="<?=$value['id'];?>"<?=($data['category']==$value['id'])?' selected':'';?>><?=$value['name'];?></option>
                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?=$message['category'];?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?=$class['description'];?>">
            <label for="message">Описание</label>
            <textarea id="message" name="description" placeholder="Напишите описание лота"><?=$data['description'];?></textarea> <!-- required -->
            <span class="form__error"><?=$message['description'];?></span>
        </div>
        <div class="form__item form__item--file <?=$class['image'];?>"> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../<?=$data['image'];?>" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="image" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
            <span class="form__error"><?=$message['image'];?></span>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?=$class['price'];?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="text" name="price" value="<?=$data['price'];?>" placeholder="0"> <!-- number required -->
                <span class="form__error"><?=$message['price'];?></span>
            </div>
            <div class="form__item form__item--small <?=$class['step'];?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="text" name="step" value="<?=$data['step'];?>" placeholder="0"> <!-- number required -->
                <span class="form__error"><?=$message['step'];?></span>
            </div>
            <div class="form__item <?=$class['date_expire'];?>">
                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="date_expire" value="<?=$data['date_expire'];?>" placeholder="20.05.2017"> <!-- required -->
                <span class="form__error"><?=$message['date_expire'];?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button" name="send">Добавить лот</button>
    </form>
</main>
