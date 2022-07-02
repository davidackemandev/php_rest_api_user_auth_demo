CREATE SCHEMA `php_rest_api_user_auth_demo` ;

CREATE TABLE `accounts` (
 `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `account_email` varchar(255) CHARACTER SET utf8 NOT NULL,
 `account_passwd` varchar(255) CHARACTER SET utf8 NOT NULL,
 `account_reg_time` timestamp NOT NULL DEFAULT current_timestamp(),
 `account_enabled` tinyint(1) unsigned NOT NULL,
 PRIMARY KEY (`account_id`),
 UNIQUE KEY `account_email` (`account_email`)
);

CREATE TABLE `account_sessions` (
 `session_id` varchar(255) CHARACTER SET utf8 NOT NULL,
 `account_id` int(10) unsigned NOT NULL,
 `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`session_id`)
);

CREATE TABLE `account_notes` (
  `note_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `account_id` int(10) UNSIGNED NOT NULL,
  `note_data` LONGTEXT NULL,
  PRIMARY KEY (`note_id`)
);