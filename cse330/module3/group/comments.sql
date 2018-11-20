CREATE TABLE `comments` (
 `comment_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `story_id` smallint(5) unsigned DEFAULT NULL,
 `owner` varchar(12) DEFAULT NULL,
 `contents` tinytext,
 PRIMARY KEY (`comment_id`),
 KEY `story_id` (`story_id`),
 KEY `owner` (`owner`),
 CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`story_id`) REFERENCES `stories` (`story_id`),
 CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`owner`) REFERENCES `users` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8
