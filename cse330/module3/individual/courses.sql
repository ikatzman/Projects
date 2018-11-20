| courses | CREATE TABLE `courses` (
  `school_code` enum('L','B','A','F','E','T','I','W','S','U','M') NOT NULL DEFAULT 'L',
  `dept_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `course_code` char(5) NOT NULL DEFAULT '',
  `name` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`school_code`,`dept_id`,`course_code`) USING BTREE,
  CONSTRAINT `courses_ibfk_1` FOREIGN KEY (`school_code`, `dept_id`) REFERENCES `departments` (`school_code`, `dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 |