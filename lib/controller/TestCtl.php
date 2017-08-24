<?php
namespace controller;
use \sf\Controller;
use \paihao\User ;



/**
* 
*/
class TestCtl extends BaseCtl
{
 
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
            $uinfo['timestamp'] = $now;
            $uinfo['skey'] = $this->genSkey($uinfo['uid'],$now);
            $this->outjson($uinfo);            
        }
        $this->error('40002');
        exit;
    }

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


    private function getSessionKeyFromWx($code){
        $r = new \QCloud_WeApp_SDK\Helper\Request();
        $options=[];
        $options['method']='POST';
        $options['url']='https://api.weixin.qq.com/sns/jscode2session';
        $options['data']=[
            'appid'=>'wx875abb8e8427771f'
            ,'secret'=>'2aa398d03c9b7064004f87f102edf792'
            ,'js_code'=>$code
            ,'grant_type'=>'authorization_code'
        ];
        $info = $r->send($options);
        return $info;
    }
}



