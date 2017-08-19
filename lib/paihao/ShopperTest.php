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
    class ShopperTest extends TestCase
    {
        public function testGetInLine(){
            //排号开始
            $line = new Line(3);            
            $in_id = $line->StartLine();

            //排队取号
            $shopper = new Shopper(21);              
            $inline = $shopper->GetInLine($in_id);
            $this->assertTrue(intval($inline->Num)>0);

            //我的排队列表
            $rows = $shopper->GetInLineList(0.10);
            $this->assertEquals(gettype($rows),'array');

            //确认收到叫号
            $inline = $shopper->GetInLine($in_id);
            $bool = $inline->ConfirmCall();
            $this->assertTrue($bool);   

            //排队取号
            $shopper = new Shopper(21);              
            $inline = $shopper->GetInLine($in_id);
            $this->assertTrue(intval($inline->Num)>0);

            //放弃排号
            $inline = $shopper->GetInLine($in_id);
            $bool = $inline->AbstainInLine();
            $this->assertTrue($bool);            

            
        }
    }



?>