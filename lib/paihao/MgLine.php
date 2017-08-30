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
* 排号管理
* @author       Administrator
*/
class MgLine extends Base
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
        if (!$uid){
            \sf\SfException::Throw("10001"); 
        }
       $this->UID = $uid;
    }
    
    /**
    * 我发起的排号列表
    * @return   array
    */
    public function MyLaunchedLineList($offset=0,$limit = 10)
    {
        $m = self::GetMySqli();
        $query = "select * from ph_line where uid=? and status > -1 order by lid desc limit ?,?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('iii',$this->UID,$offset,$limit);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);        
        $stmt->close();

        return $rows;
    }
    
    /**
    * 新建排号
    * @param    array $info    排号信息
    * @return   Line
    */
    public function CreateLine($info)
    {
        foreach (["uid","lname"] as $key => $value) {            
            if(!isset($info[$value]) || empty($info[$value])){
                return null;
            }
        } 
        $info['createtime']=time();
        $info['wx_scene']=uniqid();
        $info['status']=0;
        $m = self::GetMySqli();
        $query = "INSERT INTO `ph_line` (`uid`, `lname`, `to_tip`, `close_tip`, `createtime`, `modifytime`, `status`, `wx_scene`) VALUES (?, ?, ?, ?, ?, 0, ?, ?);";
        $stmt = $m->prepare($query);                
        $stmt->bind_param('sssssss',$info['uid'],$info['lname'],$info['to_tip'],$info['close_tip'],$info['createtime'],$info['status'],$info['wx_scene']);        
        $bool = $stmt->execute();        
        if ($bool){
            $insert_id = $stmt->insert_id;
        }
        $stmt->close();
        if($insert_id>0){
            return new Line($insert_id);
        }
    }
    
    /**
    * 获取排号
    * @param    int $lid    排号LID
    * @return   Line
    */
    public function GetLine($lid)
    {
        return new line($lid);
    }
}

?>