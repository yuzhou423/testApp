<?php
error_reporting(E_ALL | E_STRICT);
date_default_timezone_set ( "Asia/Shanghai" );

define('ROOT_PATH', dirname(dirname(__FILE__)));
define('CONFIG_PATH',   ROOT_PATH . '/application/Config');
define('CONFIG_FILE',   CONFIG_PATH . '/Config.php');
define('CORES_PATH',   dirname(ROOT_PATH) . '/core');
define('APP_PATH', ROOT_PATH.'/application');
define('CONTROLLER_PATH', APP_PATH.'/Controllers');
define('COMMON_PATH', ROOT_PATH.'/application/Common');

$application = new \Yaf\Application(require(CONFIG_FILE));
$application->bootstrap()->run();