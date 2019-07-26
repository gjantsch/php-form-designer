-- SAMPLE DATABASE

CREATE SCHEMA designer DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE designer;

SET NAMES utf8mb4;

DROP TABLE IF EXISTS countries;
SET character_set_client = utf8mb4 ;
CREATE TABLE countries (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  code varchar(2) NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  modified_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id_UNIQUE (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;


DROP TABLE IF EXISTS states;
SET character_set_client = utf8mb4 ;
CREATE TABLE states (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  country_id int(11) UNSIGNED NOT NULL,
  name varchar(100) DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_state_country FOREIGN KEY (country_id) REFERENCES countries(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS cities;
SET character_set_client = utf8mb4;
CREATE TABLE cities (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(100) NOT NULL,
  state_id int(11) UNSIGNED NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  modified_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  CONSTRAINT fk_city_state FOREIGN KEY (state_id) REFERENCES states(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

DROP TABLE IF EXISTS user;
 SET character_set_client = utf8mb4 ;
CREATE TABLE users (
  id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(255) NOT NULL,
  email varchar(100) NOT NULL,
  phone varchar(45) NOT NULL,
  gender enum('male', 'female'),
  birthdate date NOT NULL,
  birthtime time DEFAULT NULL,
  address varchar(255) NOT NULL,
  city_id int(11) UNSIGNED NOT NULL,
  state_id int(11) UNSIGNED NOT NULL,
  country_id int(11) UNSIGNED NOT NULL,
  created_at timestamp NULL DEFAULT NULL,
  modified_at timestamp NULL DEFAULT NULL,
  PRIMARY KEY (id),
  UNIQUE KEY id_UNIQUE (id),
  CONSTRAINT fk_user_city FOREIGN KEY (city_id) REFERENCES cities(id),
  CONSTRAINT fk_user_country FOREIGN KEY (country_id) REFERENCES countries(id),
  CONSTRAINT fk_user_state FOREIGN KEY (state_id) REFERENCES states(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
