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
    class MgShopperTest extends TestCase
    {
        public function testGetInLine(){

            //排号开始
            $uid=21;
            $lid=3;
            $line = new Line($lid);
            $in_id = $line->StartLine();
            $this->assertTrue($in_id>0);            
            fwrite(STDOUT,"排号开始了 ");
            $this->readFromStdin();
            //顾客排队取号
            $user = new User($uid);
            $shopper = $user->ToShopper();
            $inline = $shopper->GetInLine($in_id);
            $number = $inline->Num;
            fwrite(STDOUT,"有顾客取号了号码是:[".$number."] ");
            $this->readFromStdin();

            //指定叫号
            $mgl = new MgShopper($uid,$lid);  
            $rows = $mgl->CallNum($number);
            $this->assertEquals(gettype($rows),'array');                     
            fwrite(STDOUT,"指定叫号:[".$number."] ");
            $this->readFromStdin();

            //确认收到叫号
            $inline = $shopper->GetInLine($in_id);
            $bool = $inline->ConfirmCall();
            $this->assertTrue($bool); 
            fwrite(STDOUT,"确认收到叫号:[".$number."] ");
            $this->readFromStdin(); 

            //完成叫号            
            $bool = $mgl->MgCallComplete($number);
            $this->assertTrue($bool); 
            fwrite(STDOUT,"完成叫号:[".$number."] ");
            $this->readFromStdin(); 

            //顾客排队取号
            $user = new User($uid);
            $shopper = $user->ToShopper();
            $inline = $shopper->GetInLine($in_id);
            $number = $inline->Num;
            fwrite(STDOUT,"有顾客取号了号码是:[".$number."] ");
            $this->readFromStdin();

            //随机叫号
            $mgl = new MgShopper($uid,$lid);  
            $rows = $mgl->CallNum();
            $this->assertEquals(gettype($rows),'array');                        
            fwrite(STDOUT,"随机叫号:[".$rows['number']."] ");
            $this->readFromStdin();

        }

        private function readFromStdin(){
            fwrite(STDOUT,"任一键继续:...........");
            $arg = trim(fgets(STDIN));
            return $arg;
        }
    }



?>