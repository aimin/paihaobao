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
    class MgLineTest extends TestCase
    {   
        public function testGetMgLine(){
            $openid = 'wxopidddddd';
            $info = User::LoginFromOpenId($openid);
            $uid = $info['uid'];
            $u = new User($uid);
            $mgl = $u->GetMgline();
            $this->assertEquals(get_class($mgl),'paihao\MgLine');

            $ms = $u->GetMgShopper();
            $this->assertEquals(get_class($ms),'paihao\MgShopper');

        }


        public function testCreateLine(){
            $openid = 'wxopidddddd';
            $uinfo = User::LoginFromOpenId($openid);
            $uid = $uinfo['uid'];
            $u = new User($uid);
            $mgl = $u->GetMgline();

            $info = [];

            $info['uid']=$uinfo['uid'];//bigint(20) DEFAULT NULL,
            $info['lname']='爱民的测试用餐排号';//varchar(200) DEFAULT NULL,
            $info['to_tip']='已叫到您的排号X号,请您到服务窗口办理!';//varchar(200) DEFAULT NULL COMMENT '手机号',
            $info['close_tip']='排号已关闭，感谢你的支持！';//varchar(200) DEFAULT NULL COMMENT '微信OPPENID',
            // $info['createtime']='';//int(11) DEFAULT NULL COMMENT '创建时间',
            // $info['modifytime']='';//int(11) DEFAULT NULL COMMENT '修改时间',
            // $info['image']='';//varchar(256) DEFAULT NULL COMMENT '二维码地址',
            // $info['status']=0;//int(11) DEFAULT NULL COMMENT '-1逻辑删除,0正常，1禁用【禁用后无法启动排队】',
            //$info['wx_scene']='';//varchar(50) DEFAULT NULL COMMENT '微信小程序二维码的scene值',

            //创建一个排号
            $line = $mgl->CreateLine($info);            
            $this->assertEquals(get_class($line),'paihao\Line');

            //获得我的排号
            $rows = $mgl->MyLaunchedLineList(0,10);
            $this->assertEquals(gettype($rows),'array');

            //获得一个排号
            $line = $mgl->GetLine($rows[0]['lid']);
            $this->assertEquals(get_class($line),'paihao\Line');

        }


    }



?>