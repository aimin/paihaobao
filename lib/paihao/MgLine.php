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
* 排号管理
* @author       Administrator
*/
class MgLine
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
    * 我发起的排号列表
    * @return   array
    */
    public function MyLaunchedLineList()
    {
       // TODO: implement
    }
    
    /**
    * 新建排号
    * @param    array $info    排号信息
    * @return   Line
    */
    public function CreateLine($info)
    {
       // TODO: implement
    }
    
    /**
    * 获取排号
    * @param    int $lid    排号LID
    * @return   Line
    */
    public function GetLine($lid)
    {
       // TODO: implement
    }
}

?>