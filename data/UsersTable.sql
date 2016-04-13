CREATE TABLE users (
  id       INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
  username VARCHAR(255) DEFAULT NULL UNIQUE,
  email    VARCHAR(255) DEFAULT NULL UNIQUE,
  password VARCHAR(128)                       NOT NULL
)
  ENGINE = InnoDB;

INSERT INTO users (email, password) VALUES ('lehoanganh25991@gmail.com','034f5ceee147deb2cb37ea102fd05e13c02e6e8e');
INSERT INTO users (email, password) VALUES ('hoanganh25991@gmail.com','034f5ceee147deb2cb37ea102fd05e13c02e6e8e');
INSERT INTO users (email, password) VALUES ('hoanganh_25991@yahoo.com.vn','034f5ceee147deb2cb37ea102fd05e13c02e6e8e');

