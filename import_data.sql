use yeticave;

/* Категории */

insert into `category` set `name` = 'Доски и лыжи';
insert into `category` set `name` = 'Крепления';
insert into `category` set `name` = 'Ботинки';
insert into `category` set `name` = 'Одежда';
insert into `category` set `name` = 'Инструменты';
insert into `category` set `name` = 'Разное';

/* Пользователи */

insert into `user` set
  `date_reg` = now(),
  `email`    = 'ignat.v@gmail.com',
  `name`     = 'Игнат',
  `password` = '$2y$10$OqvsKHQwr0Wk6FMZDoHo1uHoXd4UdxJG/5UDtUiie00XaxMHrW8ka',
  `avatar`   = 'img/user.jpg',
  `contacts` = '';

insert into `user` set
  `date_reg` = now(),
  `email`    = 'kitty_93@li.ru',
  `name`     = 'Леночка',
  `password` = '$2y$10$bWtSjUhwgggtxrnJ7rxmIe63ABubHQs0AS0hgnOo41IEdMHkYoSVa',
  `avatar`   = 'img/user.jpg',
  `contacts` = '';

insert into `user` set
  `date_reg` = now(),
  `email`    = 'warrior07@mail.ru',
  `name`     = 'Руслан',
  `password` = '$2y$10$2OxpEH7narYpkOT1H5cApezuzh10tZEEQ2axgFOaKW.55LxIJBgWW',
  `avatar`   = 'img/user.jpg',
  `contacts` = '';

/* Объявления */

insert into `lot` set
  `date_create` = now(),
  `name`        = '2014 Rossignol District Snowboard',
  `description` = 'Здесь должно быть описание для доски Rossignol District',
  `image`       = 'img/lot-1.jpg',
  `price`       = '10000',
  `date_expire` = date_add(now(), interval 1 month),
  `step`        = '500',
  `owner`       = '1',
  `category`    = '1';

insert into `lot` set
  `date_create` = now(),
  `name`        = 'DC Ply Mens 2016/2017 Snowboard',
  `description` = 'Здесь должно быть описание для доски DC Ply Mens',
  `image`       = 'img/lot-2.jpg',
  `price`       = '15000',
  `date_expire` = date_add(now(), interval 1 month),
  `step`        = '500',
  `owner`       = '2',
  `category`    = '1';

insert into `lot` set
  `date_create` = now(),
  `name`        = 'Крепления Union Contact Pro 2015 года размер L/XL',
  `description` = 'Здесь должно быть описание для крепления Union Contact Pro',
  `image`       = 'img/lot-3.jpg',
  `price`       = '8000',
  `date_expire` = date_add(now(), interval 1 month),
  `step`        = '300',
  `owner`       = '3',
  `category`    = '2';

insert into `lot` set
  `date_create` = now(),
  `name`        = 'Ботинки для сноуборда DC Mutiny Charocal',
  `description` = 'Здесь должно быть описание для ботинок DC Mutiny Charocal',
  `image`       = 'img/lot-4.jpg',
  `price`       = '6000',
  `date_expire` = date_add(now(), interval 1 month),
  `step`        = '200',
  `owner`       = '1',
  `category`    = '3';

insert into `lot` set
  `date_create` = now(),
  `name`        = 'Куртка для сноуборда DC Mutiny Charocal',
  `description` = 'Здесь должно быть описание для куртки DC Mutiny Charocal',
  `image`       = 'img/lot-5.jpg',
  `price`       = '7500',
  `date_expire` = date_add(now(), interval 1 month),
  `step`        = '200',
  `owner`       = '2',
  `category`    = '4';

insert into `lot` set
  `date_create` = now(),
  `name`        = 'Маска Oakley Canopy',
  `description` = 'Здесь должно быть описание для маски Oakley Canopy',
  `image`       = 'img/lot-6.jpg',
  `price`       = '5400',
  `date_expire` = date_add(now(), interval 1 month),
  `step`        = '100',
  `owner`       = '3',
  `category`    = '6';

/* Ставки */

insert into `bet` set `date` = now(), `price` = '10000', `user` = '2', `lot` = '1';
insert into `bet` set `date` = now(), `price` = '10500', `user` = '2', `lot` = '1';
insert into `bet` set `date` = now(), `price` = '11000', `user` = '2', `lot` = '1';
insert into `bet` set `date` = now(), `price` = '11500', `user` = '2', `lot` = '1';
