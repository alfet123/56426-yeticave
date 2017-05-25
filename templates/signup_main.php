<main>
    <nav class="nav">
        <ul class="nav__list container">
            <?php foreach ($categories as $key => $value): ?>
            <li class="nav__item">
                <a href="pages/all-lots.html"><?=$value->name;?></a>
            </li>
            <?php endforeach; ?>
        </ul>
    </nav>
    <form class="form container <?=$class['form'];?>" action="signup.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
        <h2>Регистрация нового аккаунта</h2>
        <div class="form__item <?=$class['email'];?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" value="<?=$data['email'];?>" placeholder="Введите e-mail"> <!-- required -->
            <span class="form__error"><?=$message['email'];?></span>
        </div>
        <div class="form__item <?=$class['password'];?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" value="<?=$data['password'];?>" placeholder="Введите пароль"> <!-- required -->
            <span class="form__error"><?=$message['password'];?></span>
        </div>
        <div class="form__item <?=$class['name'];?>">
            <label for="name">Имя*</label>
            <input id="name" type="text" name="name" value="<?=$data['name'];?>" placeholder="Введите имя"> <!-- required -->
            <span class="form__error"><?=$message['name'];?></span>
        </div>
        <div class="form__item <?=$class['contacts'];?>">
            <label for="message">Контактные данные*</label>
            <textarea id="message" name="contacts" placeholder="Напишите как с вами связаться"><?=$data['contacts'];?></textarea> <!-- required -->
            <span class="form__error"><?=$message['contacts'];?></span>
        </div>
        <div class="form__item form__item--file form__item--last">
            <label>Изображение</label>
            <div class="preview">
                <button class="preview__remove" type="button">x</button>
                <div class="preview__img">
                    <img src="img/avatar.jpg" width="113" height="113" alt="Аватар">
                </div>
            </div>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="photo2" name="avatar" value="">
                <label for="photo2">
                    <span>+ Добавить</span>
                </label>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button" name="send">Зарегистрироваться</button>
        <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
</main>
