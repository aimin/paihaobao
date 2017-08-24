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
* 用户
* @author       Administrator
*/
class User extends Base
{
    
    /**
    * 用户ID
    * @var      int
    */
    private $UID;    
    
    /**
    * 构造方法
    * @param    int $uid    用户UID
    * @return   void
    */
    public function __construct($uid)
    {
       $this->UID = $uid;
    }
    
    /**
    * 获得顾客管理
    * @param  $lid 排号id
    * @return   MgShopper
    */
    public function GetMgShopper($lid)
    {
        return new MgShopper($this->UID,$lid);
    }
    
    /**
    * 获理排号管理
    * @return   MgLine
    */
    public function GetMgLine()
    {
       return new MgLine($this->UID);
    }

    //更新用户信息
    public function Update($upInfo)
    {
        $m = self::GetMySqli();        
        $names = "";
        $value_names = "";
        $formats = "s";
        foreach ($upInfo as $key => $value) {
            $formats = $formats . 's';
            $names = $names.',`'.$key.'`=?';
            $value_names = $value_names.',$'.$key;
        }
        $names = substr($names,1);            
        $value_names = substr($value_names,1); 
        $query="update `ph_users` set ".$names." where `uid` = ? ;";        
        $stmt = $m->prepare($query);        
        extract($upInfo);
        eval(sprintf('$stmt->bind_param($formats,%s,$this->UID);',$value_names));

        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
    }
    
    /**
    * 静态方法：用户注册,返回用户ID,
    * @param    array $userinfo    用户信息
    * @return   User
    */
    public static function Reg($userinfo)
    {
        foreach (["name","mob","wxopid","wxunionid"] as $key => $value) {            
            if(!isset($userinfo[$value]) || empty($userinfo[$value])){
                return null;
            }
        }
        
        $userinfo['createtime'] = time();        
        $m = self::GetMySqli();
        $query = "INSERT INTO `ph_users` (`name`, `pwd`, `nick`, `mob`, `wxopid`, `wxunionid`, `createtime`, `image`, `userinfo`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('sssssssss',$userinfo['name'],$userinfo['pwd'],$userinfo['nick'],$userinfo['mob'],$userinfo['wxopid'],$userinfo['wxunionid'],$userinfo['createtime'],$userinfo['image'],$userinfo['userinfo']);        
        $bool = $stmt->execute();        
        if ($bool){
            $insert_id = $stmt->insert_id;
        }
        $stmt->close();
        if($insert_id>0){
            return new User($insert_id);
        }
        return null;
    }
    
    /**
    * 静态方法：微信OPENID用户登录
    * @param    string $openid    微信OPENID
    * @return   array
    */
    public static function LoginFromOpenId($openid)
    {
        if(!$openid)
            return null;

        $m = self::GetMySqli();
        $query = "select * from ph_users where wxopid=?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('s',$openid);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);        
        $stmt->close();
        unset($row['pwd']);

        if($row['uid']>0){
            return $row;
        }
        return null;
    }

    //用户详情
    public function detail(){
        $m = self::GetMySqli();
        $query = "select * from ph_users where uid=?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('s',$this->UID);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);        
        $stmt->close();
        unset($row['pwd']);
        
        if($row['uid']>0){
            return $row;
        }
        return null;
    }
    
    /**
    * 静态方法：微信UNIONID用户登录
    * @param    string $unionid    微信UNIONID
    * @return   array
    */
    public static function LoginFromUnionID($unionid)
    {
       if(!$unionid)
            return null;

        $m = self::GetMySqli();
        $query = "select * from ph_users where wxunionid=?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('s',$unionid);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);        
        $stmt->close();
        unset($row['pwd']);
        
        if($row['uid']>0){
            return $row;
        }
        return null;
    }
    
    /**
    * 静态方法：用户名,密码KEY登录
    * @param    string $name    用户名
    * @param    string $key    密码KEY=md5(用户名+md5(密码))
    * @return   array
    */
    public static function LoginFromKey($name, $key)
    {
       // TODO: implement
    }
    
    /**
    * 用户转为顾客    
    * @return   Shopper
    */
    public function ToShopper()
    {
       return new Shopper($this->UID);  
    }

    //微信sence转为排号的LID
    public static function WxSenceToLID($wxSence){
        //获取排次
        $query = "select * from ph_line where `wx_scene`=?;"; 
        $stmt = $m->prepare($query);
        $stmt->bind_param('s',$wxSence);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        if(intval($row['lid'])>0){
            return $row['lid'];
        }else{
            return false;
        }
    }
}

?>