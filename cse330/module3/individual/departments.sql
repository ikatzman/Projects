CREATE TABLE `departments` (
 `school_code` enum('L','B','A','F','E','T','I','W','S','U','M') NOT NULL DEFAULT 'L',
 `dept_id` tinyint(3) unsigned NOT NULL DEFAULT '0',
 `abbreviation` varchar(9) DEFAULT NULL,
 `dept_name` varchar(200) DEFAULT NULL,
 PRIMARY KEY (`school_code`,`dept_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
