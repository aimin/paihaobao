<?php
namespace paihao;
//
// +------------------------------------------------------------------------+
// | PHP Version 7                                                          |
// +------------------------------------------------------------------------+
// +------------------------------------------------------------------------+
// | Author: songaimin@outlook.com  blog:http://blog.csdn.net/samxx8                                                             |
// +------------------------------------------------------------------------+
//
// $Id$
//

define('ROOT_PATH',dirname(__FILE__).'/../');
define('CONF_PATH',sprintf("%s/../%s",ROOT_PATH,"conf"));
define('LIB_PATH',sprintf("%s/../%s",ROOT_PATH,"lib"));
require_once sprintf("%s/sf/Sf.php",LIB_PATH);
$sf = new \sf\Sf();
$sf->run();



use PHPUnit\Framework\TestCase;
    class PaihaoTest extends TestCase
    {
        public function test(){
            echo 8888;
        }

        private function readFromStdin($msg){
            fwrite(STDOUT,sprintf("%s..........任一键继续:...........",$msg));
            $arg = trim(fgets(STDIN));
            return $arg;
        }
    }



?>