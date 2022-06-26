CREATE SCHEMA `php_rest_api_user_auth_demo` ;

CREATE TABLE `accounts` (
 `account_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
 `account_email` varchar(255) CHARACTER SET utf8 NOT NULL,
 `account_passwd` varchar(255) CHARACTER SET utf8 NOT NULL,
 `account_reg_time` timestamp NOT NULL DEFAULT current_timestamp(),
 `account_enabled` tinyint(1) unsigned NOT NULL,
 PRIMARY KEY (`account_id`),
 UNIQUE KEY `account_email` (`account_email`)
) ENGINE=MyISAM AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

CREATE TABLE `account_sessions` (
 `session_id` varchar(255) CHARACTER SET utf8 NOT NULL,
 `account_id` int(10) unsigned NOT NULL,
 `login_time` timestamp NOT NULL DEFAULT current_timestamp(),
 PRIMARY KEY (`session_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;