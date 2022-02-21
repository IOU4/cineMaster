CREATE DATABASE IF NOT EXISTS CineMaster;
use CineMaster;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password BINARY(64) NOT NULL,
  PRIMARY KEY(id)
);
CREATE TABLE IF NOT EXISTS posts (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(60),
  description TEXT(250),
  likes_count INT, 
  author_id INT, 
  cover VARCHAR(255),
  PRIMARY KEY(id),
  FOREIGN KEY(author_id) REFERENCES users(id)
);
CREATE TABLE IF NOT EXISTS comments (
  id int auto_increment,
  post_id int,
  author_id int,
  content text(500),
  PRIMARY KEY(id),
  FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(author_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO users (
  title, 
  description, 
  likes_count,
  ) VALUES ( 
  "Inception",
  "yet another decpario movie , this one is dream and stuff", 
  289
);

INSERT INTO users (
  title, 
  description, 
  likes_count,
  ) VALUES ( 
  "shuter island",
  "leonardo decaprio makes prefect again, this thing gonna hurt your brain for a while ", 
  332
);
