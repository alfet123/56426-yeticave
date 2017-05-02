<main>
    <nav class="nav">
        <ul class="nav__list container">
            <li class="nav__item">
                <a href="all-lots.html">Доски и лыжи</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Крепления</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Ботинки</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Одежда</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Инструменты</a>
            </li>
            <li class="nav__item">
                <a href="all-lots.html">Разное</a>
            </li>
        </ul>
    </nav>
    <form class="form form--add-lot container <?=$class['form'];?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <div class="form__item <?=$class['lot-name'];?>"> <!-- form__item--invalid -->
                <label for="lot-name">Наименование</label>
                <input id="lot-name" type="text" name="lot-name" value="<?=$data['lot-name'];?>" placeholder="Введите наименование лота"> <!-- required -->
                <span class="form__error"><?=$message['lot-name'];?></span>
            </div>
            <div class="form__item <?=$class['category'];?>">
                <label for="category">Категория</label>
                <select id="category" name="category"> <!-- required -->
                    <option>Выберите категорию</option>
                    <option>Доски и лыжи</option>
                    <option>Крепления</option>
                    <option>Ботинки</option>
                    <option>Одежда</option>
                    <option>Инструменты</option>
                    <option>Разное</option>
                </select>
                <span class="form__error"><?=$message['category'];?></span>
            </div>
        </div>
        <div class="form__item form__item--wide <?=$class['message'];?>">
            <label for="message">Описание</label>
            <textarea id="message" name="message" placeholder="Напишите описание лота"><?=$data['message'];?></textarea> <!-- required -->
            <span class="form__error"><?=$message['message'];?></span>
        </div>
        <div class="form__item form__item--file <?=$class['lot-image'];?>"> <!-- form__item--uploaded -->
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="../<?=$data['lot-image'];?>" width="113" height="113" alt="Изображение лота">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="lot-image" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <div class="form__container-three">
            <div class="form__item form__item--small <?=$class['lot-rate'];?>">
                <label for="lot-rate">Начальная цена</label>
                <input id="lot-rate" type="text" name="lot-rate" value="<?=$data['lot-rate'];?>" placeholder="0"> <!-- number required -->
                <span class="form__error"><?=$message['lot-rate'];?></span>
            </div>
            <div class="form__item form__item--small <?=$class['lot-step'];?>">
                <label for="lot-step">Шаг ставки</label>
                <input id="lot-step" type="text" name="lot-step" value="<?=$data['lot-step'];?>" placeholder="0"> <!-- number required -->
                <span class="form__error"><?=$message['lot-step'];?></span>
            </div>
            <div class="form__item <?=$class['lot-date'];?>">
                <label for="lot-date">Дата завершения</label>
                <input class="form__input-date" id="lot-date" type="text" name="lot-date" value="<?=$data['lot-date'];?>" placeholder="20.05.2017"> <!-- required -->
                <span class="form__error"><?=$message['lot-date'];?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>
