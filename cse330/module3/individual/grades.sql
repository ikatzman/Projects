CREATE TABLE `grades` (
 `pk_grade_ID` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
 `student_id` mediumint(8) unsigned DEFAULT NULL,
 `grade` decimal(5,2) DEFAULT NULL,
 `school_code` enum('L','B','A','F','E','T','I','W','S','U','M') DEFAULT NULL,
 `dept_id` tinyint(3) unsigned DEFAULT NULL,
 `course_code` char(5) DEFAULT NULL,
 PRIMARY KEY (`pk_grade_ID`),
 KEY `school_code` (`school_code`,`dept_id`),
 KEY `student_id` (`student_id`),
 CONSTRAINT `grades_ibfk_1` FOREIGN KEY (`school_code`, `dept_id`) REFERENCES `courses` (`school_code`, `dept_id`),
 CONSTRAINT `grades_ibfk_2` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1
