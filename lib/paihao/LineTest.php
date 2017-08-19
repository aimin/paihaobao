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
    class LineTest extends TestCase
    {   
        public function testStartLine(){
            $lid=3;
            $line = new Line($lid);
            //排队开始异常
            try{
                $in_id = $line->StartLine();                                    
            }catch(\sf\SfException $e){
                $this->assertEquals($e->getCode(),30002);
            }

            //逻辑删除异常
            try{
                $line->DeleteLine();
            }catch(\sf\SfException $e){
                $this->assertEquals($e->getCode(),30000);
            }

            //排队停止
            $bool = $line->StopLine(); 
            $this->assertTrue($bool);            

            //逻辑删除
            $bool = $line->DeleteLine();
            $this->assertTrue($bool);  

            //启用
            $bool = $line->EnableLine();
            $this->assertTrue($bool);
            
            //开始
            $in_id = $line->StartLine();
            $this->assertTrue($in_id>0);

            //详情
            $info = $line->InLineDetail();
            $this->assertEquals(gettype($info['line']),'array');
            $this->assertEquals(gettype($info['inline']),'array');

            //禁用异常            
            try{
                $line->DisableLine();
            }catch(\sf\SfException $e){
                $this->assertEquals($e->getCode(),30000);
            }

            //排队停止
            $bool = $line->StopLine(); 
            $this->assertTrue($bool);

            //禁用
            $bool = $line->DisableLine();
            $this->assertTrue($bool);

            //启用
            $bool = $line->EnableLine();
            $this->assertTrue($bool);

            //详情
            $info = $line->HistoryInLineList(0,10);
            $this->assertEquals(gettype($info),'array');

        }

        public function testUpdateLine(){
            $lid=3;
            $line = new Line($lid);
            $upinfo = [];
            $upinfo['lname']="nnnnnnnnnn";
            $upinfo['to_tip']="oooooooooo";
            $bool = $line->UpdateLine($upinfo); 
            $this->assertTrue($bool);

        }

       
    }

?>