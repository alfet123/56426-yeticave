/*  получить список из всех категорий  */

select `name` from `category`;

/*  получить самые новые, открытые лоты
    каждый лот должен включать:
    - название,
    - стартовую цену,
    - ссылку на изображение,
    - цену,
    - количество ставок,
    - название категории  */

select `lot.id`, `lot.name`, `lot.price`, `lot.image`, max(`bet.price`), count(`bet.id`), `category.name`
from (`lot`
join `category` on `lot.category` = `category.id`)
join `bet` on `lot.id` = `bet.lot`
where now() < `lot.date_expire` and `lot.winner` is null
group by `lot.id`
order by `lot.date_create` desc
limit 3;

/*  найти лот по его названию или описанию  */

select * from `lot` where `name` like '%board%' or `description` like '%доска%';

/*  добавить новый лот (все данные из формы добавления)  */

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

/*  обновить название лота по его идентификатору  */

update `lot` set `name` = 'Крепление Union Contact Pro 2017 года' where `id` = '3';

/*  добавить новую ставку для лота  */

insert into `bet` set
  `date` = now(),
  `price` = '8500',
  `user` = '2',
  `lot` = '5'

/*  получить список ставок для лота по его идентификатору  */

select `bet.date`, `bet.price`, `user.name`
from `bet`
join `user` on `bet.user` = `user.id`
where `bet.lot` = '3';
