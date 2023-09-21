<?php 

define('INSTANCE_URL', 'http://localhost/suplike'); // replace with instace url


// Define database config
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'suplike_bot');

// authorizations
define("API_KEY", ""); // user api key
define("BOT_ID","");  // access token
define('FROM_ID', ''); // chat id

// debug settings
if(!defined("DEBUG_ENABLED"))  define("DEBUG_ENABLED", false);

if(!defined("DEBUG_DIRECTORY"))  define("DEBUG_DIRECTORY", "log/");

if(!defined("DEBUG_FILE"))  define("DEBUG_FILE", "debug.log.txt");