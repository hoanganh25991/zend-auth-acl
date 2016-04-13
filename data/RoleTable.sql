CREATE TABLE role (
  id       INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  rolename VARCHAR(255) DEFAULT NULL UNIQUE
)
  ENGINE = InnoDB;

INSERT INTO role (rolename) VALUE ('guest');
INSERT INTO role (rolename) VALUE ('editor');
INSERT INTO role (rolename) VALUE ('admin');
