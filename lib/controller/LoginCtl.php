<?php
namespace controller;
use \sf\Controller;
use \paihao\User ;



/**
* 
*/
class LoginCtl extends BaseCtl
{   
    //微信code登录
    function codeLogin(){
        $code = $_REQUEST['code'];
        $wxInfo = $this->getSessionKeyFromWx($code);        
        if($wxInfo['status']==200 && !isset($wxInfo['body']['errcode'])){  
            $uinfo = User::LoginFromOpenId($wxInfo['body']['openid']);          
            if(!$uinfo){
                $user = $this->regUserFromWxInfo($wxInfo);
                if($user){
                    $uinfo = User::LoginFromOpenId($wxInfo['body']['openid']);
                }else{
                    $this->error('40001');
                }
            }            
            $now = time();
            $user = new User($uinfo['uid']);            
            $user->Update(["lastlogintime"=>$now]);
            $uinfo['timestamp'] = $now;
            $uinfo['skey'] = $this->genSkey($uinfo['uid'],$now);
            $this->outjson($uinfo);            
        }
        $this->error('40002');
        exit;
    }

    //更新微信用户信息
    function updateUser(){
        $this->chkSkey($this->getReqestHeader());
        $uid = $this->getReqestHeader('uid');        

        $user = new User($uid);
        $detail = $user->detail($uid);        
        $info = [];
        if($detail){
            $ori_info = json_decode($detail['userinfo'],true);
            $wxuserinfo = array_merge($ori_info,$_REQUEST);
            $info['userinfo'] = json_encode($wxuserinfo,true);
        }

        $info['name'] = $_REQUEST['nickName'];
        $info['nick'] = $_REQUEST['nickName'];  
        $info['image'] = $_REQUEST['avatarUrl'];        

        
        $bool = $user->Update($info);
        $this->outjson($bool);
        exit;
    }

    function testQ(){        
        $bool = $this->chkSkey($this->getReqestHeader());
        $this->outjson($bool);
    }

    //微信用户注册
    private function regUserFromWxInfo($wxInfo){
        $ninfo=[];
        $uniqid = uniqid();
        $ninfo['name']=$uniqid ;
        $ninfo['pwd']=md5("123456");
        $ninfo['nick']=$uniqid ;
        $ninfo['mob']=$uniqid ;
        $ninfo['wxopid']=$wxInfo['body']['openid'];
        $ninfo['wxunionid']=uniqid();           
        $ninfo['image']="";
        $ninfo['userinfo']=json_encode($wxInfo['body'],true);

        $user = User::Reg($ninfo);
        return $user;
    }

    //微信code获取sessionkey
    private function getSessionKeyFromWx($code){

        $wxconfig = \sf\Config::Get('wx');

        $r = new \QCloud_WeApp_SDK\Helper\Request();
        $options=[];
        $options['method']='POST';
        $options['url']='https://api.weixin.qq.com/sns/jscode2session';
        $options['data']=[
            'appid'=>$wxconfig['wxappid']
            ,'secret'=>$wxconfig['wxappsecret']
            ,'js_code'=>$code
            ,'grant_type'=>$wxconfig['wxgrant_type']
        ];
        $info = $r->send($options);
        return $info;
    }
}



