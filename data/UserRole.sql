CREATE TABLE userrole (
  id      INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  user_id INTEGER,
  role_id INTEGER
)
  ENGINE = InnoDB;
INSERT INTO userrole(user_id, role_id) VALUES (1, 3);
INSERT INTO userrole(user_id, role_id) VALUES (2, 2);
INSERT INTO userrole(user_id, role_id) VALUES (3, 1);
