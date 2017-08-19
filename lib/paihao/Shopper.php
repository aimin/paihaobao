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
* 顾客
* @author       Administrator
*/
class Shopper
{
    
    /**
    * 顾客ID
    * @var      int
    */
    private $CID;
    
    /**
    * 构造方法
    * @param    int $uid    顾客UID
    * @return   void
    */
    public function __construct($uid)
    {
       // TODO: implement
    }
    
    /**
    * 获理排队管理
    * @param    int $in_id    排次ID
    * @return   InLine
    */
    public function GetInLine($in_id)
    {
       // TODO: implement
    }
    
    /**
    * 获得我的排队列表
    * @return   array
    */
    public function GetInLineList()
    {
       // TODO: implement
    }
}

?>