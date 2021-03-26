CREATE TABLE company (
  id integer(11) unsigned not null auto_increment primary key,
  name varchar(256) not null,
  prefecture_id integer(11) unsigned not null,
  company_kind_id integer(11) unsigned not null,
  CONSTRAINT fk_prefecture_id
    FOREIGN KEY (prefecture_id)
    REFERENCES prefecture (id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
  CONSTRAINT fk_company_kind_id
    FOREIGN KEY (company_kind__id)
    REFERENCES company_kind (company_kind_id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB;
