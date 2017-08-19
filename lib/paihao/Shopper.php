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
* 顾客
* @author       Administrator
*/
class Shopper extends Base
{
    
    /**
    * 顾客ID
    * @var      int
    */
    private $UID;
    
    /**
    * 构造方法
    * @param    int $uid    顾客UID
    * @return   void
    */
    public function __construct($uid)
    {
       $this->UID= $uid;
    }
    
    /**
    * 排队并取号
    * @param    int $in_id    排次ID
    * @return   InLine
    */
    public function GetInLine($in_id)
    {
       return new InLine($this->UID,$in_id);
    }
    
    /**
    * 获得我的排队列表
    * @return   array
    */
    public function GetInLineList($offset=0,$limit=10)
    {
        $m = self::GetMySqli();

        //获取排次
        $query = "select * from ph_shopper where uid=? limit ?,?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('sss',$this->UID,$offset,$limit);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);        
        $stmt->close();
        if (count($rows)>0)
            return $rows;
        else
            return false;
    }
}

?>