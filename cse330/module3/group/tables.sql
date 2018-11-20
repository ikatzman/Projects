Users table:

CREATE TABLE `users` (
 `username` varchar(12) NOT NULL DEFAULT '',
 `password_hash` varchar(255) DEFAULT NULL,
 PRIMARY KEY (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

Stories table:

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


Comments table:

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
