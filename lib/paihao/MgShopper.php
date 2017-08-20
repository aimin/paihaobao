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
* 顾客管理
* @author       Administrator
*/
class MgShopper extends Base
{
    
    /**
    * 用户ID
    * @var      int
    */
    private $UID;    
    private $lid;
    
    /**
    * 构造方法
    * @param    int $uid    用户UID
    * @return   void
    */
    public function __construct($uid,$lid)
    {
       $this->UID = $uid;
       $this->lid = $lid;
    }
    /**
    * 叫号
    * @param    int $InLineNum    排队号
    * @return   shopperRow
    */
    public function CallNum($InLineNum=false)
    {
        $line = new Line($this->lid);
        $inlineRows = $line->getInLineRows(0,1);        
        if (count($inlineRows)>0 && intval($inlineRows[0]['status'])!=1){
            //未开始排队
            \sf\SfException::Throw(29001); 
        }
        $in_id = $inlineRows[0]['in_id'];

        $m = self::GetMySqli();
        if($InLineNum){
            //指定叫号
            $query = "SELECT * FROM ph_shopper WHERE uid=? AND in_id=? AND number=? AND status IN (0,1);"; 
            $stmt = $m->prepare($query);
            $stmt->bind_param('ddi',$this->UID,$in_id,$InLineNum);
            $bool = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (intval($row['cid'])<1){
                \sf\SfException::Throw(30003); 
            }
        }else{
           //顺序叫号 
            $curr_num = $inlineRows[0]['curr_num'];
            $query = "SELECT * FROM `ph_shopper` WHERE `in_id`=? AND `number`>? AND `STATUS`=0 ORDER BY number ASC LIMIT 1;"; 
            $stmt = $m->prepare($query);
            $stmt->bind_param('di',$in_id,$curr_num);
            $bool = $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_array(MYSQLI_ASSOC);
            if (intval($row['cid'])<1){
                \sf\SfException::Throw(30004); 
            }
        }

        //更新排号的当前叫号
        $query="update `ph_inline` set `curr_num`=? where `in_id` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('ss',$row['number'],$in_id);
        $bool = $stmt->execute();
        $stmt->close();

        //更新呼叫次数        
        $now = time();
        $query="update `ph_shopper` set `callsum`=`callsum`+1,modifytime=?,status=1 where `cid` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('ss',$now,$row['cid']);
        $bool = $stmt->execute();
        $stmt->close();

        $row['callsum']=$row['callsum']+1;
        $row['modifytime']=$now;
        return $row;       
    }
    
    /**
    * 管理员消号
    * @param    int $InLineNum    排队号
    * @return   boolean
    */
    public function MgCancelNum($InLineNum)
    {
        $line = new Line($this->lid);
        $inlineRows = $line->getInLineRows(0,1);        
        if (count($inlineRows)>0 && intval($inlineRows[0]['status'])!=1){
            //未开始排队
            \sf\SfException::Throw(29001); 
        }
        $in_id = $inlineRows[0]['in_id'];

        //置管理员消号 
        $m = self::GetMySqli();      
        $now = time();
        $query="update `ph_shopper` set `status`=-2,modifytime=? where `in_id`=? and `number` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('sss',$now,$in_id,$InLineNum);
        $bool = $stmt->execute();
        $stmt->close();

        if($bool){
            //更新排号的当前叫号
            $query="update `ph_inline` set `abstain_sum`=`abstain_sum`+1 where `in_id` = ? ;";
            $stmt = $m->prepare($query);
            $stmt->bind_param('s',$in_id);
            $bool = $stmt->execute();
            $stmt->close();    
        }
        
        return $bool;
    }


    /**
    * 叫号完成
    * @param    int $InLineNum    
    * @return   boolean
    */
    public function MgCallComplete($InLineNum)
    {
        $line = new Line($this->lid);
        $inlineRows = $line->getInLineRows(0,1);        
        if (count($inlineRows)>0 && intval($inlineRows[0]['status'])!=1){
            //未开始排队
            \sf\SfException::Throw(29001); 
        }
        $in_id = $inlineRows[0]['in_id'];

        //置完成叫号      
        $m = self::GetMySqli();
        $now = time();
        $query="update `ph_shopper` set `status`=3,modifytime=? where `in_id`=? and `number` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('sss',$now,$in_id,$InLineNum);
        $bool = $stmt->execute();
        $stmt->close();       
        
        return $bool;
    }
    
    /**
    * 我的顾客列表
    * @return   array
    */
    public function ShopperList($offset=0,$limit=10)
    {
       //TODO: implement
        $line = new Line($this->lid);
        $inlineRows = $line->getInLineRows(0,1);        
        if (count($inlineRows)>0 && intval($inlineRows[0]['status'])!=1){
            //未开始排队
            \sf\SfException::Throw(29001); 
        }
        $in_id = $inlineRows[0]['in_id'];

        //获取排次
        $m = self::GetMySqli();
        $query = "select * from `ph_inline` where `in_id`=? order by number desc limit ?,?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('sss',$in_id,$offset,$limit);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);        
        $stmt->close();
        if(count($rows)>0){
            return $rows;
        }

        return false;
    }
    
}

?>