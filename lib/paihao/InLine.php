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
* 排队
* @author       Administrator
*/
class InLine
{
    
    /**
    * 用户ID
    * @var      int
    */
    private $UID;
    
    /**
    * 排次ID
    * @var      int
    */
    private $in_id;
    
    /**
    * 构造方法
    * @param    int $uid    用户ID
    * @param    int $in_id    排次ID
    * @return   void
    */
    public function __construct($uid, $in_id)
    {
       // TODO: implement
    }
    
    /**
    * 放弃排队
    * @return   boolean
    */
    public function AbstainInLine()
    {
       // TODO: implement
    }
    
    /**
    * 取号
    * @return   int
    */
    public function GetInLineNum()
    {
       // TODO: implement
    }
    
    /**
    * 确认收到叫号
    * @return   boolean
    */
    public function ConfirmCall()
    {
       // TODO: implement
    }
}

?>