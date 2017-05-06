create table `category` (
  `id` int unsigned not null auto_increment primary key,
  `name` char(32) not null
);

create table `lot` (
  `id` int unsigned not null auto_increment primary key,
  `date_create` datetime not null,
  `name` char(64) not null,
  `description` char(128),
  `image` char(255),
  `price` decimal not null,
  `date_expire` datetime,
  `step` decimal not null,
  `likes` int,
  `owner` int unsigned not null,
  `winner` int unsigned,
  `category` int unsigned not null
);

create table `bet` (
  `id` int unsigned not null auto_increment primary key,
  `date` datetime not null,
  `price` decimal not null,
  `user` int unsigned not null,
  `lot` int unsigned not null
);

create table `user` (
  `id` int unsigned not null auto_increment primary key,
  `date_reg` datetime not null,
  `email` char(32) not null,
  `name` char(64) not null,
  `password` char(32) not null,
  `avatar` char(255),
  `contacts` char(64) not null
);

create unique index `category_name` on `category`(`name`);
create unique index `user_email` on `user`(`email`);

create index `lot_category` on `lot`(`category`);
create index `user_email` on `user`(`email`);
create index `lot_owner` on `lot`(`owner`);
create index `bet_user` on `bet`(`user`);
create index `bet_lot` on `bet`(`lot`);