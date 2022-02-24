CREATE DATABASE IF NOT EXISTS CineMaster;
use CineMaster;
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  email VARCHAR(100) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id)
);
CREATE TABLE IF NOT EXISTS posts (
  id INT NOT NULL AUTO_INCREMENT,
  title VARCHAR(60),
  description TEXT(250),
  likes_count INT, 
  author_id INT, 
  cover VARCHAR(255),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY(author_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);
CREATE TABLE IF NOT EXISTS comments (
  id INT AUTO_INCREMENT,
  post_id INT,
  author_id INT,
  content text(500),
  created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY(id),
  FOREIGN KEY(post_id) REFERENCES posts(id) ON DELETE CASCADE ON UPDATE CASCADE,
  FOREIGN KEY(author_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE CASCADE
);

INSERT INTO users (
  id,
  username,
  email,
  password
) VALUES ( 
  1,
  'emaduo',
  'adim@emad.me',
  'secret'
);

INSERT INTO users (
  id,
  username,
  email,
  password
) VALUES ( 
  2,
  'jawad',
  'adim@jawad.me',
  'secret2'
);

INSERT INTO posts (
  id,
  title, 
  description, 
  likes_count,
  author_id
  ) VALUES ( 
  1,
  'Inception',
  'yet another decpario movie , this one is about dreams and stuff', 
  289,
  1
);

INSERT INTO posts (
  id,
  title, 
  description, 
  likes_count,
  author_id
  ) VALUES ( 
  2,
  'shuter island',
  'leonardo decaprio makes prefect again, this thing gonna hurt your brain for a while', 
  332,
  2
);

INSERT INTO comments (
  id,
  post_id,
  author_id, 
  content
) VALUES ( 
  1,
  1,
  1, 
  'this is an awesome movie, I strongly recommend it'
);

INSERT INTO comments (
  id,
  post_id,
  author_id, 
  content
) VALUES ( 
  2,
  2,
  2, 
  'this is an awesome movie, I strongly recommend it'
);
