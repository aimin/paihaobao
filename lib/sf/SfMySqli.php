<?php
namespace sf;
/*
mysqli操作类
 */
class SfMySqli extends \mysqli
{
    public function Update($tablename,$upInfo,$where)
    {
        $m = self::GetMySqli();        
        $names = "";
        $value_names = "";
        $formats = "ss";
        foreach ($upInfo as $key => $value) {
            $formats = $formats . 's';
            $names = $names.',`'.$key.'`=?';
            $value_names = $value_names.',$'.$key;
        }
        $names = substr($names,1);
        $value_names = substr($value_names,1); 
        $query="update ? set ".$names." where ".$where." ;";        
        $stmt = $m->prepare($query);        
        extract($upInfo);
        eval(sprintf('$stmt->bind_param($formats,$tablename,%s);',$value_names));

        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
    }
}
