CREATE TABLE `users` (
 `username` varchar(12) NOT NULL DEFAULT '',
 `password_hash` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
