<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2025-07-30 14:37:38 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 55
ERROR - 2025-07-30 14:38:06 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 55
ERROR - 2025-07-30 14:38:10 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 55
ERROR - 2025-07-30 14:38:27 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 55
ERROR - 2025-07-30 14:38:31 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 55
ERROR - 2025-07-30 15:24:44 --> 404 Page Not Found: /index
ERROR - 2025-07-30 15:25:47 --> 404 Page Not Found: /index
ERROR - 2025-07-30 15:25:53 --> 404 Page Not Found: /index
ERROR - 2025-07-30 15:26:03 --> 404 Page Not Found: /index
ERROR - 2025-07-30 15:26:03 --> 404 Page Not Found: /index
ERROR - 2025-07-30 15:38:21 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '1' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `posts`
LEFT JOIN `categories` ON `categories`.`id`=`posts`.`category`
WHERE `posts`.`type` = 'post'
AND `categories`.`slug` = 'berita'
AND `poststatus` = `=` 1
ERROR - 2025-07-30 15:38:46 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '1' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `posts`
LEFT JOIN `categories` ON `categories`.`id`=`posts`.`category`
WHERE `posts`.`type` = 'post'
AND `categories`.`slug` = 'berita'
AND `poststatus` = `=` 1
ERROR - 2025-07-30 15:38:49 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near '2' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `posts`
LEFT JOIN `categories` ON `categories`.`id`=`posts`.`category`
WHERE `posts`.`type` = 'post'
AND `categories`.`slug` = 'berita'
AND `poststatus` = `=` 2
ERROR - 2025-07-30 15:40:06 --> Query error: Unknown column 'poststatus' in 'WHERE' - Invalid query: SELECT `regulations`.*, `documentcategories`.`category`, `documentcategories`.`acronym`, `documentcategories`.`acslug` as `dcslug`
FROM `regulations`
LEFT JOIN `documentcategories` ON `documentcategories`.`id`=`regulations`.`documentcategory`
WHERE `regulations`.`groups` = 'regulation'
AND `poststatus` = 1
ORDER BY `regulations`.`viewed` DESC
 LIMIT 6
ERROR - 2025-07-30 15:43:20 --> Severity: error --> Exception: syntax error, unexpected ';', expecting ')' C:\xampp\htdocs\jdih\application\modules\web\controllers\Posts.php 37
ERROR - 2025-07-30 15:44:29 --> Query error: No tables used - Invalid query: SELECT *
 LIMIT 2
ERROR - 2025-07-30 15:46:07 --> Query error: Unknown column 'categories.category' in 'SELECT' - Invalid query: SELECT `posts`.*, `categories`.`category` as `categoryname`
FROM `posts`
WHERE `poststatus` != 4
ORDER BY `posts`.`id` DESC
 LIMIT 2
ERROR - 2025-07-30 15:46:42 --> Severity: error --> Exception: Call to undefined method Posts_model::get_limit_data() C:\xampp\htdocs\jdih\application\modules\web\controllers\Posts.php 62
ERROR - 2025-07-30 15:57:03 --> 404 Page Not Found: /index
ERROR - 2025-07-30 16:29:52 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL
AND `regulations`.`isdeleted` = 0' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `regulations`
LEFT JOIN `documentcategories` ON `documentcategories`.`id`=`regulations`.`documentcategory`
LEFT JOIN `documenttypes` ON `documenttypes`.`id`=`regulations`.`doctype`
WHERE `regulations`.`groups` = 'regulation'
AND  IS NULL
AND `regulations`.`isdeleted` = 0
ERROR - 2025-07-30 16:31:24 --> Severity: error --> Exception: Call to a member function total_rows() on null C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 87
ERROR - 2025-07-30 16:32:02 --> Severity: error --> Exception: Call to a member function total_rows() on null C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 91
ERROR - 2025-07-30 16:32:08 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL
AND `regulations`.`isdeleted` = 0' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `regulations`
LEFT JOIN `documentcategories` ON `documentcategories`.`id`=`regulations`.`documentcategory`
LEFT JOIN `documenttypes` ON `documenttypes`.`id`=`regulations`.`doctype`
WHERE `regulations`.`groups` = 'regulation'
AND  IS NULL
AND `regulations`.`isdeleted` = 0
ERROR - 2025-07-30 16:37:37 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 39
ERROR - 2025-07-30 16:37:53 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 39
ERROR - 2025-07-30 16:37:57 --> Severity: error --> Exception: syntax error, unexpected ':', expecting ')' C:\xampp\htdocs\jdih\application\modules\app\controllers\Regulations.php 39
ERROR - 2025-07-30 16:39:53 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL
AND `regulations`.`isdeleted` = 0' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `regulations`
LEFT JOIN `documentcategories` ON `documentcategories`.`id`=`regulations`.`documentcategory`
LEFT JOIN `documenttypes` ON `documenttypes`.`id`=`regulations`.`doctype`
WHERE `regulations`.`groups` = 'regulation'
AND  IS NULL
AND `regulations`.`isdeleted` = 0
ERROR - 2025-07-30 16:40:17 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL
AND `regulations`.`isdeleted` = 0' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `regulations`
LEFT JOIN `documentcategories` ON `documentcategories`.`id`=`regulations`.`documentcategory`
LEFT JOIN `documenttypes` ON `documenttypes`.`id`=`regulations`.`doctype`
WHERE `regulations`.`groups` = 'regulation'
AND  IS NULL
AND `regulations`.`isdeleted` = 0
ERROR - 2025-07-30 16:40:47 --> Query error: You have an error in your SQL syntax; check the manual that corresponds to your MariaDB server version for the right syntax to use near 'IS NULL
AND `regulations`.`isdeleted` = 0
AND   (
`regulations`.`title` LIKE ...' at line 6 - Invalid query: SELECT COUNT(*) AS `numrows`
FROM `regulations`
LEFT JOIN `documentcategories` ON `documentcategories`.`id`=`regulations`.`documentcategory`
LEFT JOIN `documenttypes` ON `documenttypes`.`id`=`regulations`.`doctype`
WHERE `regulations`.`groups` = 'regulation'
AND  IS NULL
AND `regulations`.`isdeleted` = 0
AND   (
`regulations`.`title` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`slug` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`documentcategory` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`doctype` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`teu` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`regulationnumber` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`registrationnumber` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`callnumber` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`year` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`edition` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`assignmentplace` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`assignmentdate` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`approvaldate` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`effectivedate` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`location` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`source` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`language` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`legalfield` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`subject` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`cluster` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`status` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`detailstatus` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`bookcover` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`isbnissnnumber` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`publisher` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`description` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`liked` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`abstract` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`abstractfile` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`attachment` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`published` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`publishdate` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`reason` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`isdeleted` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`createdat` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`createdby` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`updatedat` LIKE '%Array%' ESCAPE '!'
OR  `regulations`.`updatedby` LIKE '%Array%' ESCAPE '!'
OR  `documentcategories`.`category` LIKE '%Array%' ESCAPE '!'
OR  `documentcategories`.`acronym` LIKE '%Array%' ESCAPE '!'
OR  `documenttypes`.`documenttype` LIKE '%Array%' ESCAPE '!'
 )
