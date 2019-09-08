<?php

define("DB_NAME", "fluff");
define("DB_HOST", getenv("MYSQL_HOST"));
define("DB_USER", getenv("MYSQL_USER"));
define("DB_PASSWORD", getenv("MYSQL_PASS"));
define("DB_TABLE", "data");


define("SESSION_USER", "__fluffy_user__");

define("SITE_PATH", "../site");
define("SITE_URL", getenv("SERVER_HOST"));



define("SMTP_USERNAME", "");
define("SMTP_PASSWORD", "");
define("SMTP_HOST", "ssl://smtp.yandex.ru");
define("SMTP_PORT", 465);
define("SMTP_CHARSET", "utf-8");
if(!defined('PHP_EOL')) define('PHP_EOL', '\r\n');


?>