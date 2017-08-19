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
* 排号
* @author       Administrator
*/
class Line
{
    
    /**
    * 排号ID
    * @var      int
    */
    private $LID;
    
    /**
    * 构造方法
    * @param    int $lid    排号LID
    * @return   void
    */
    public function __construct($lid)
    {
       // TODO: implement
    }
    
    /**
    * 排号开始排队
    * @return   void
    */
    public function StartLine()
    {
       // TODO: implement
    }
    
    /**
    * 排号停止排队
    * @return   void
    */
    public function StopLine()
    {
       // TODO: implement
    }
    
    /**
    * 逻辑删除排号
    * @return   void
    */
    public function DeleteLine()
    {
       // TODO: implement
    }
    
    /**
    * 查看排号详情
    * @return   array
    */
    public function LineDetail()
    {
       // TODO: implement
    }
    
    /**
    * 更新排号
    * @param    array $upInfo    需要更新的信息[key:value]
    * @return   void
    */
    public function UpdateLine($upInfo)
    {
       // TODO: implement
    }
    
    /**
    * 生成取号二维码的URL
    * @return   string
    */
    public function GetQCodeURLForNum()
    {
       // TODO: implement
    }
    
    /**
    * 排号的历史排队
    * @return   array
    */
    public function HistoryInLineList()
    {
       // TODO: implement
    }
}

?>