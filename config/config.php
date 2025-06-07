<?php

/** Configuration Variables **/
/* 上线后记得改为0*/
define ('DEVELOPMENT_ENVIRONMENT',1);


define('DB_NAME', 'qianzhi_db');
define('DB_USER', 'root');
define('DB_PASSWORD', 'yourdbpassword');
define('DB_HOST', '127.0.0.1');
define('BASE_PATH','https://zhangqingya.cn');

ini_set('date.timezone','Asia/Shanghai');
$date = getdate();

$CURRENT_TIME = $date['year'].$date['yday'].$date['mon'].$date['mday'].$date['weekday'].$date['wday'];

define('CURRENT_TIME',$CURRENT_TIME);
define('PAGINATE_LIMIT', '5');

define("CAPTCHA_ID", "你的极验ID");
define("PRIVATE_KEY", "你的极验私钥");
