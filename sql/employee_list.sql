CREATE TABLE employee_list (
  id integer(11) unsigned not null auto_increment primary key,
  first_name varchar(256) not null,
  last_name varchar(256) not null,
  division varchar(256) not null,
  email varchar(256) not null,
  tel_num varchar(256) not null
) ENGINE = InnoDB;
