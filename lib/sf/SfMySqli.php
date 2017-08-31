<?php
namespace sf;
/*
mysqli操作类
 */
class SfMySqli extends \mysqli
{
    /**
    * 用户ID
    * @var      int
    */
    protected static $mysqli;    
    
    /**
    * 获取mysql客户端    
    * @return   mysqli_client
    */
    public static function GetMySqli()
    {
       $cfg = \sf\Config::Get('db');       
       if (!self::$mysqli ){
            self::$mysqli=new SfMySqli($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['dbname']);
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
       }
       return self::$mysqli;
    }

    public function Update($tablename,$upInfo,$where)
    {
        $m = self::GetMySqli();        
        $names = "";
        $value_names = "";
        $formats = "";
        foreach ($upInfo as $key => $value) {
            $formats = $formats . 's';
            $names = $names.',`'.$key.'`=?';
            $value_names = $value_names.',$'.$key;
        }
        $names = substr($names,1);        
        $value_names = substr($value_names,1); 
        $query="update `$tablename` set ".$names." where ".$where." ;";             
        $stmt = $m->prepare($query);        
        extract($upInfo);        
        eval(sprintf('$stmt->bind_param($formats,%s);',$value_names));
        
        $bool = $stmt->execute();
        $stmt->close(); 

        return $bool;
    }
}
