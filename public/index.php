<?php
define('ROOT_PATH',dirname(__FILE__));
define('CONF_PATH',sprintf("%s/../%s",ROOT_PATH,"conf"));
define('LIB_PATH',sprintf("%s/../%s",ROOT_PATH,"lib"));

require_once sprintf("%s/sf/Sf.php",LIB_PATH);

$sf = new sf\Sf();
$sf->run();

// $cfg = sf\Config::Get('db');

// print_r($cfg);

// $u = new sf\SfMySqli("192.168.1.101", "dbuser", "123456", "yth");

// print_r($u);



phpinfo();



