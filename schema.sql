create table `category` (
  `id` int auto_increment primary key,
  `name` char(32)
);

create table `lot` (
  `id` int auto_increment primary key,
  `date_create` datetime,
  `name` char(32),
  `description` char(64),
  `image` char(64),
  `price` decimal,
  `date_expire` datetime,
  `step` decimal,
  `likes` int,
  `owner` int,
  `winner` int,
  `category` int
);

create table `bet` (
  `id` int auto_increment primary key,
  `date` datetime,
  `price` decimal,
  `user` int,
  `lot` int
);

create table `user` (
  `id` int auto_increment primary key,
  `date_reg` datetime,
  `email` char(32),
  `name` char(32),
  `password` char(32),
  `avatar` char(64),
  `contacts` char(64),
  `lot` int,
  `bet` int
);

create unique index `category_name` on `category`(`name`);
create unique index `user_email` on `user`(`email`);

create index `lot_name` on `lot`(`name`);
create index `lot_description` on `lot`(`description`);
