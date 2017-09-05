<?php
namespace controller;
use \sf\Controller;



/**
* 
*/
class BaseCtl extends Controller
{
    public $NotChkPers = [];
    
    public function __construct()
    {
        parent::__construct();
        
        $this->addIgnoreChkPersList("LoginCtl/codeLogin");
        if(!$_GET['debug']){
            $this->chkSkey($this->getReqestHeader());    
        }
        
    }

    //忽略权限检查
    public function addIgnoreChkPersList($controllerAction){
        $this->NotChkPers[]=$controllerAction;
    }

    public function error($code){
        $data = \sf\Config::Get('err')[$code];
        echo json_encode(['status'=>$code,'data'=>$data],true);
        exit;
    }

    public function outjson($data){
        $r = [];
        $r['status'] = 200;
        $r['data'] = $data;
        $json = json_encode($r,true);
        echo $json;
        exit;
    }

    //读取RequestHeader内容
    public function getReqestHeader($name=false){
        $headers = getallheaders();
        if($name){
            return $headers[$name];
        }else{
            return $headers;
        }
    }

    //生成登录后的skey
    public function genSkey($uid,$now){        
        $name = "s_".$uid;
        setcookie($name,$now,time()+2678400);
        $skey = md5($uid.'|'.$now.'|paihaobao');
        return $skey;
    }

    //检查skey是否有效
    public function chkSkey($requestHeaders){
        if(in_array($_GET['controller']."/".$_GET['action'], $this->NotChkPers)){
            return true;
        }
        $uid = $requestHeaders['uid'];
        $skey = $requestHeaders['skey'];
        $now = $requestHeaders['timestamp'];
        $return = true;
        if(!$skey){
            $return = false;
        }
        if((time()-intval($now))>267840/2){
            $return = false;
        }
        $c_skey = md5($uid.'|'.$now.'|paihaobao');
        $return = ($c_skey == $skey);
        if(!$return){
            $this->error('40003');
        }
        return $return;
    }
}



