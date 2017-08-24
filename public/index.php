<?php
define('ROOT_PATH',dirname(__FILE__));
define('CONF_PATH',sprintf("%s/../%s",ROOT_PATH,"conf"));
define('LIB_PATH',sprintf("%s/../%s",ROOT_PATH,"lib"));

require_once sprintf("%s/sf/Sf.php",LIB_PATH);

#加载wx_sdk
require_once sprintf("%s/wafer-php-server-sdk-master/AutoLoader.php",LIB_PATH);


$sf = new sf\Sf();
$sf->run();

#初始化wx_sdk
\QCloud_WeApp_SDK\Conf::setup(sf\Config::Get('wx'));



