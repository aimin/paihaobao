<?php
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
class User
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
       // TODO: implement
    }
    
    /**
    * 获得顾客管理
    * @return   MgShopper
    */
    public function GetMgShopper()
    {
       // TODO: implement
    }
    
    /**
    * 获理排号管理
    * @return   MgLine
    */
    public function GetMgLine()
    {
       // TODO: implement
    }
    
    /**
    * 静态方法：用户注册,返回用户ID,
    * @param    array $userinfo    用户信息
    * @return   User
    */
    public function Reg($userinfo)
    {
       // TODO: implement
    }
    
    /**
    * 静态方法：微信OPENID用户登录
    * @param    string $openid    微信OPENID
    * @return   array
    */
    public function LoginFromOpenId($openid)
    {
       // TODO: implement
    }
    
    /**
    * 静态方法：微信UNIONID用户登录
    * @param    string $unionid    微信UNIONID
    * @return   array
    */
    public function LoginFromUnionID($unionid)
    {
       // TODO: implement
    }
    
    /**
    * 静态方法：用户名,密码KEY登录
    * @param    string $name    用户名
    * @param    string $key    密码KEY=md5(用户名+md5(密码))
    * @return   array
    */
    public function LoginFromKey($name, $key)
    {
       // TODO: implement
    }
    
    /**
    * 用户转为顾客
    * @param    string $wx_scene    用户的微信scene
    * @return   Shopper
    */
    public function ToShopper($wx_scene)
    {
       // TODO: implement
    }
}

?>