CREATE DATABASE IF NOT EXISTS CineMaster;
use CineMaster;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT,
  username varchar(50) NOT NULL UNIQUE,
  email varchar(100) NOT NULL UNIQUE,
  password varchar(100) NOT NULL,
  PRIMARY KEY(id),
);
CREATE DATABASE IF NOT EXISTS posts ()
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(60),
  description TEXT(250),
  comments_count INT(1000),
  author_id INT, 
  PRIMARY KEY(id),
  FOREIGN KEY(author_id) REFERENCES users(id)
);
CREATE TABLE IF NOT EXISTS comments (
  id int auto_increment,
  post_id int,
  author_id int,
  content text(500),
  PRIMARY KEY(id),
  FOREIGN KEY(post_id) REFERENCES posts(id),
  FOREIGN KEY(author_id) REFERENCES users(id)
);
