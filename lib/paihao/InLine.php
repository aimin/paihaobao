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
* 排队
* @author       Administrator
*/
class InLine extends Base
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


    public $Num; //排队号码
    
    /**
    * 构造方法
    * @param    int $uid    用户ID
    * @param    int $in_id    排次ID
    * @return   void
    */
    public function __construct($uid, $in_id)
    {
       $this->UID=$uid;
       $this->in_id=$in_id;
       $this->genNum();
    }

    //微信sence转为排号的排次ID
    public static function wxSenceToInID(){
         // TODO: implement
    }
    
    /**
    * 放弃排队
    * @return   boolean
    */
    public function AbstainInLine()
    {
        $m = self::GetMySqli();
        //启用
        $now = time();        
        $query="update `ph_shopper` set `status`=-1 , modifytime=? where uid=? and in_id=? and status in (0,1) ;";
        $stmt = $m->prepare($query);        
        $stmt->bind_param('sss',$now,$this->UID,$this->in_id);
        $bool = $stmt->execute();
        $stmt->close();

        return $bool;
    }

    public function GetInLineRow(){
        $m = self::GetMySqli();
        $query = "select * from ph_inline where in_id=?;"; 
        $stmt = $m->prepare($query);
        $stmt->bind_param('i',$this->in_id);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        if(intval($row['lid'])>0){
            return $row;
        }else{
            return false;
        }
    }

    
    /**
    * 生成排队号码
    * @return   int
    */
    private function genNum()
    {
        $m = self::GetMySqli();

        //查询排队号码
        $query = "select * from ph_shopper where uid=? and in_id=? and status in (0,1,2);"; 
        $stmt = $m->prepare($query);
        $stmt->bind_param('dd',$this->UID,$this->in_id);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        if(intval($row['cid'])>0){
            $this->Num=$row['number'];
            return ;
        }

        //生成排队号码
        $inlinerow = $this->GetInLineRow();
        $lid= $inlinerow['lid'];
        $max_num = $inlinerow['sum'];
        $num = $max_num+1;
        $now = time();
        
        $query = "INSERT INTO `ph_shopper` (`uid`, `lid`, `in_id`, `createtime`, `number`, `callsum`, `status`) VALUES (?, ?, ?, ?, ?, 0, 0);"; 
        $stmt = $m->prepare($query);                        
        $stmt->bind_param('ssssi',$this->UID,$lid,$this->in_id,$now,$num);
        $bool = $stmt->execute();        
        if ($bool){
            $this->Num=$num;
            $c_id = $stmt->insert_id;
        }
    }
    
    /**
    * 确认收到叫号
    * @return   boolean
    */
    public function ConfirmCall()
    {
        $m = self::GetMySqli();
        //启用
        $now = time();        
        $query="update `ph_shopper` set `status`=2 , modifytime=? where uid=? and in_id=? and status = 1 ;";
        $stmt = $m->prepare($query);        
        $stmt->bind_param('sss',$now,$this->UID,$this->in_id);
        $bool = $stmt->execute();
        $stmt->close();

        return $bool;
    }
}

?>