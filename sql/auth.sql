CREATE TABLE auth (
  id integer(11) unsigned not null auto_increment primary key,
  user_name varchar(256) not null,
  hashed_passowrd varchar(256) not null
) ENGINE = InnoDB;

ALTER TABLE auth ADD INDEX idx_auth_user (user_name);