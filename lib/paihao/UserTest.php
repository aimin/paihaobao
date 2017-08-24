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
    class UserTest extends TestCase
    {
        public function testReg()
        {
            // echo PHP_VERSION;            
            $info=[];
            $info['name']="samtest";//varchar(200) DEFAULT NULL,
            $info['pwd']=md5("123456");//varchar(200) DEFAULT NULL,
            $info['nick']="samnick";//varchar(200) DEFAULT NULL,
            $info['mob']="13552528384";//char(11) DEFAULT NULL COMMENT '手机号',
            $info['wxopid']="wxopidddddd";//varchar(200) DEFAULT NULL COMMENT '微信OPPENID',
            $info['wxunionid']="wxunionidddddd";//varchar(200) DEFAULT NULL COMMENT '微信unionID',                        
            $info['image']="http://avatar.csdn.net/7/6/4/1_samxx8.jpg";//varchar(256) DEFAULT NULL COMMENT '头像',
            $info['userinfo']="{}";//text COMMENT '微信用户信息',
            
            $user = User::Reg($info);
            $this->assertEquals(get_class($user),'paihao\User');
        }

        public function testUpdate(){
            $user = new User(21);
            $info = [];
            $info['name'] = 'xxxx1';
            $info['nick'] = 'xxxx_nick';
            $bool = $user->Update($info);
            $this->assertTrue($bool);

        }

        public function testLoginFromOpenId(){
            $openid = 'wxopidddddd';
            $info = User::LoginFromOpenId($openid);
            $this->assertEquals(gettype($info),'array');

            $unionid = 'wxunionidddddd';
            $info = User::LoginFromUnionID($unionid);
            $this->assertEquals(gettype($info),'array');            
            
        }        

    }



?>