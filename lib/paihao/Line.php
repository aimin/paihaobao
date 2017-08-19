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
* 排号
* @author       Administrator
*/
class Line extends Base
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
       $this->LID = $lid;
    }
    
    /**
    * 排号开始
    * @return   in_id
    */
    public function StartLine()
    {
        $m = self::GetMySqli();
        
        $lineRow = $this->Get();

        if($lineRow==false){            
             \sf\SfException::Throw(30001); 
        }
        if($lineRow['status']==-1){
             \sf\SfException::Throw(30002); 
        }

        $in_id = $this->getInId();

        if($in_id>0){            
            return $in_id;
        }else{
            //开启排次
            $now = time();            
            $query="INSERT INTO `ph_inline` (`lid`, `sum`, `curr_num`,`abstain_sum`, `starttime`, `stoptime`, `status`)VALUES( ? , 0, 0, 0, ? , 0, 1);";
            $stmt = $m->prepare($query);                                  
            $stmt->bind_param('ss',$this->LID,$now);        
            $bool = $stmt->execute();
            if ($bool){
                $in_id = $stmt->insert_id;
            }
            $stmt->close(); 
            return $in_id;
        }
    }

    /*
    获取排号
     */
    public function Get(){
        $m = self::GetMySqli();

        //获取排次
        $query = "select * from ph_line where lid=?;"; 
        $stmt = $m->prepare($query);
        $stmt->bind_param('s',$this->LID);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        if ($row['lid']>0)
            return $row;
        else
            return false;
    }

    /*
    获取进行中排次id
     */
    private function getInId(){
        $m = self::GetMySqli();

        //获取排次
        $query = "select * from ph_inline where status in (0,1);"; 
        $stmt = $m->prepare($query);
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $inlineRow = $result->fetch_array(MYSQLI_ASSOC);
        $stmt->close();
        if ($inlineRow['in_id']>0)
            return $inlineRow['in_id'];
        else
            return false;
    }
    
   

    /**
    * 排号停止
    * @return   bool
    */
    public function StopLine()
    {
        $m = self::GetMySqli();
        $in_id = $this->getInId();

        //停止排次
        $now = time();
        $query="update `ph_inline` set `status`=2 , `stoptime`=? where `in_id` = ? and `status`= 1 ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('ss',$now,$in_id);
        $bool = $stmt->execute();
        $stmt->close(); 
        
        return $bool;
    }
    
    /**
    * 逻辑删除的排号，在列表中看不到
    * @return   bool
    */
    public function DeleteLine()
    {
        $m = self::GetMySqli();
        $in_id = $this->getInId();
        if($in_id>0){
            \sf\SfException::Throw(30000);            
        }
        //逻辑删除排号
        $now = time();
        $query="update `ph_line` set `status`=-1,modifytime=? where `lid` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('ss',$now,$this->LID);
        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
    }

    /**
    * 禁用排号,列表中可以看到,便不能排号
    * @return   void
    */
    public function DisableLine()
    {
        $m = self::GetMySqli();
        $in_id = $this->getInId();
        if($in_id>0){
            \sf\SfException::Throw(30000);            
        }

        //禁用
        $now = time();
        $query="update `ph_line` set `status`=1,modifytime=? where `lid` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('ss',$now,$this->LID);
        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
    }
    /**
    * 启用排号
    * @return   void
    */
    public function EnableLine()
    {
        $m = self::GetMySqli();

        //启用
        $now = time();
        $query="update `ph_line` set `status`=0,modifytime=? where `lid` = ? ;";
        $stmt = $m->prepare($query);
        $stmt->bind_param('ss',$now,$this->LID);
        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
    }
    
    /*
    获取排次列表
     */
    private function getInLineRows($offset=0,$limit=1){
        $m = self::GetMySqli();

        //获取排次
        $query = "select * from ph_inline where lid=? order by status asc limit ?,?;"; 
        $stmt = $m->prepare($query);                
        $stmt->bind_param('sss',$this->LID,$offset,$limit);        
        $bool = $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);        
        $stmt->close();
        if (count($rows)>0)
            return $rows;
        else
            return false;
    }

    /**
    * 查看排号中详情
    * @return   array
    */
    public function InLineDetail()
    {
       $detail = [];
       $detail['line'] = $this->Get();
       $detail['inline'] = $this->getInLineRows()[0];       
       return $detail;
    }
    
    /**
    * 更新排号
    * @param    array $upInfo    需要更新的信息[key:value]
    * @return   void
    */
    public function UpdateLine($upInfo)
    {
        $m = self::GetMySqli();        
        $names = "";
        $value_names = "";
        $formats = "s";
        foreach ($upInfo as $key => $value) {
            $formats = $formats . 's';
            $names = $names.',`'.$key.'`=?';
            $value_names = $value_names.',$'.$key;
        }
        $names = substr($names,1);            
        $value_names = substr($value_names,1); 
        $query="update `ph_line` set ".$names." where `lid` = ? ;";        
        $stmt = $m->prepare($query);        
        extract($upInfo);
        eval(sprintf('$stmt->bind_param($formats,%s,$this->LID);',$value_names));

        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
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
    * 排号的历史排次
    * @return   array
    */
    public function HistoryInLineList($offset=0,$limit=10)
    {
       return $this->getInLineRows($offset,$limit);
    }
}

?>