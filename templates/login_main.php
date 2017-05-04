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
    <form class="form container <?=$class['form'];?>" action="login.php" method="post"> <!-- form--invalid -->
        <h2>Вход</h2>
        <div class="form__item <?=$class['email'];?>"> <!-- form__item--invalid -->
            <label for="email">E-mail*</label>
            <input id="email" type="text" name="email" value="<?=$data['email'];?>" placeholder="Введите e-mail"> <!-- required -->
            <span class="form__error">Введите e-mail</span>
        </div>
        <div class="form__item form__item--last <?=$class['password'];?>">
            <label for="password">Пароль*</label>
            <input id="password" type="text" name="password" value="<?=$data['password'];?>" placeholder="Введите пароль"> <!-- required -->
            <span class="form__error">Введите пароль</span>
        </div>
        <button type="submit" class="button" name="send">Войти</button>
    </form>
</main>
