--11.04.14
added in apache/conf/extra/httpd-vhosts.conf
  php_value include_path .;C:/xampp/htdocs/pkop/include;C:/xampp/php/PEAR
  т.к. не работал  класс Templates
added in .htaccess
  php_value error_reporting off
  т.к. warnings
Smarty2.6.18-dist var
  2.6.28 - current
--14.04.14
--------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  `user_type` varchar(20) NOT NULL,
  `ts_created` datetime NOT NULL,
  `ts_last_login` datetime DEFAULT NULL,
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
----------------------------------------------
CREATE TABLE IF NOT EXISTS `users_profile` (
  `user_id` bigint(20) unsigned NOT NULL,
  `profile_key` varchar(255) NOT NULL,
  `profile_value` text NOT NULL,
  PRIMARY KEY (`user_id`,`profile_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Ограничения внешнего ключа таблицы `users_profile`
ALTER TABLE `users_profile`
  ADD CONSTRAINT `users_profile_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
