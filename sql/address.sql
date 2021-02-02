CREATE TABLE address (
  id integer(11) unsigned not null auto_increment primary key,
  first_name varchar(256) not null,
  last_name varchar(256) not null,
  country varchar(256) not null,
  prefecture varchar(256) not null,
  word_or_city varchar(256) not null,
  street varchar(256) not null,
  tel_num varchar(256) not null
) ENGINE = InnoDB;
