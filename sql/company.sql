CREATE TABLE company (
  id integer(11) unsigned not null auto_increment primary key,
  name varchar(256) not null,
  prefecture_id integer(11) unsigned not null,
  kind_id integer(11) unsigned not null,
) ENGINE = InnoDB;
