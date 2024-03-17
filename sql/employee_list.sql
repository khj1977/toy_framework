CREATE TABLE employee_list (
  id integer(11) unsigned not null auto_increment primary key,
  first_name varchar(256) not null,
  last_name varchar(256) not null,
  division_id integer(11) unsigned not null,
  email varchar(256) not null,
  tel_num varchar(256) not null,
  CONSTRAINT fk_company_kind_id
    FOREIGN KEY (division_id)
    REFERENCES division (id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB;

---

alter table employee_list add column memo TEXT;
