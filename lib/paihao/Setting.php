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


/**
* 设置
* @author       Administrator
*/
class Setting extends Base
{
        
    /**
     * 保存设置
     * @return  array
     */
    public static function Save($info){

        if( !isset($info['sid']) && !isset($info['name']) ){
            \sf\SfException::Throw(31000);
        }
        if(isset($info['sid']) && $info['sid']){
            $setting = self::GetBySID($info['sid']);            
            $where = sprintf("`sid`= '%s' ",$info['sid']);
        }else{
            $setting = self::GetByName($info['name']);            
            $where = sprintf("`name`= '%s' ",$info['name']);
        }

        $m = self::GetMySqli();
        if($setting){
            //更新
            $now = time();
            $info['lasttime']=$now;
            $m->Update('ph_setting',$info,$where);
        }else{
            //保存access_token            
            $now = time();
            $query = "INSERT INTO `ph_setting` ( `name`, `value`, `lasttime`, `createtime`) VALUES (?, ?, ?, ?);";
            $stmt = $m->prepare($query);
            $stmt->bind_param( 'ssss' , $info['name'] , $info['value'], $now , $now );
            $bool = $stmt->execute();
            if ($bool){
                $in_id = $stmt->insert_id;
            }
            $stmt->close();
        }
    }
    
    /**
     * 获取设置
     */
    public static function GetByName($name){
        $m = self::GetMySqli();

        //获取设置
        $query = "select * from ph_setting where name=?;"; 
        $stmt = $m->prepare($query);
        $stmt->bind_param('s',$name);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        return $row;
    }

    /**
     * 获取设置
     */
    public static function GetBySID($sid){
        $m = self::GetMySqli();

        //获取设置
        $query = "select * from ph_setting where sid=?;"; 
        $stmt = $m->prepare($query);
        $stmt->bind_param('s',$sid);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        return $row;
    }


    /**
     * 获得生成小程序码的access_token
     * @return  array
     */
    public static function GetWxAccessToken(){
        $info = Setting::GetByName('accessToken');        
        $re_get = true;
        if($info){            
            $at = json_decode($info['value'],true);
            $expire = intval($at['expires_in'])+$info['lasttime']-10;            
            if($expire>time()){
                //access_token有效直接返回
                return $at;   
            }
        }

        //重新获得    
        // https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
        $wxconfig = \sf\Config::Get('wx');
        $r = new \QCloud_WeApp_SDK\Helper\Request();
        $options=[];
        $options['method']='GET';
        $options['url']=sprintf("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s",$wxconfig['wxappid'],$wxconfig['wxappsecret']);
        $options['data']=[];
        $info = $r->send($options);
        //保存
        Setting::save(["name"=>'accessToken','value'=>json_encode($info['body'],true)]);    
        
        

        return $info['body'];
    }
   
}

?>