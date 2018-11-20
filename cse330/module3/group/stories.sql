CREATE TABLE `stories` (
 `owner` varchar(12) DEFAULT NULL,
 `title` varchar(100) DEFAULT NULL,
 `contents` text,
 `story_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `link` tinytext,
 `likes` int(11) NOT NULL,
 `dislikes` int(11) NOT NULL,
 `views` int(11) NOT NULL,
 PRIMARY KEY (`story_id`),
 KEY `owner` (`owner`),
 CONSTRAINT `stories_ibfk_1` FOREIGN KEY (`owner`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8
