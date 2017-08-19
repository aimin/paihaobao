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
* 顾客管理
* @author       Administrator
*/
class MgShopper
{
    
    /**
    * 用户ID
    * @var      int
    */
    private $UID;
    
    /**
    * 叫号
    * @param    int $InLineNum    排队号
    * @return   boolean
    */
    public function CallNum($InLineNum)
    {
       // TODO: implement
    }
    
    /**
    * 管理员消号
    * @param    int $InLineNum    排队号
    * @return   boolean
    */
    public function MgCancelNum($InLineNum)
    {
       // TODO: implement
    }
    
    /**
    * 我的顾客列表
    * @return   array
    */
    public function ShopperList()
    {
       // TODO: implement
    }
    
    /**
    * 构造方法
    * @param    int $uid    用户UID
    * @return   void
    */
    public function __construct($uid)
    {
       // TODO: implement
    }
}

?>