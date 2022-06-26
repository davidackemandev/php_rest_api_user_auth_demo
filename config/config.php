<?php
// (A) DATABASE SETTINGS
define("DB_HOST", "localhost");
define("DB_NAME", "php_rest_api_user_auth_demo");
define("DB_CHARSET", "utf8");
define("DB_USER", "dva_desktop");
define("DB_PASSWORD", "V!triol@2027");
 
// (B) JWT STUFF
define("JWT_SECRET", "xjQFHG(xcC88LpA@!853dvqvwcZAKzAt");
define("JWT_ISSUER", "notedb");
define("JWT_AUD", "srv2.notedb.com");
define("JWT_ALGO", "HS512");

// Google API configuration
define('GOOGLE_CLIENT_ID', '694005500987-acfcfdlr2doh0tsb4lk082tcv7deas0i.apps.googleusercontent.com');
define('GOOGLE_CLIENT_SECRET', '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');
define('GOOGLE_REDIRECT_URL', 'https://srv2.notedb.app/server/public/google_auth.php');