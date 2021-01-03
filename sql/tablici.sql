-- таблица пользователей
CREATE TABLE polzovateli (
  id_polzovately int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
  login_polzovately varchar(100) NOT NULL,
  imy_polzovately varchar(100) NULL,
  familiy_polzovately varchar(100) NULL,
  email varchar(100) NOT NULL,
  parol varchar(270) NOT NULL,
  id_shifr varchar(270) NULL,
  registraciy TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

-- таблица избранных
CREATE TABLE best_users (
  boss_id int (10) unsigned NOT NULL,
  best_user_id int (10) unsigned NOT NULL
)