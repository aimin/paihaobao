<?php
namespace paihao;
use \sf\SfMySqli as mysql;
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
* 用户
* @author       Administrator
*/
class Base
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
            self::$mysqli=new mysql($cfg['host'], $cfg['user'], $cfg['pwd'], $cfg['dbname']);
            if (mysqli_connect_errno()) {
                printf("Connect failed: %s\n", mysqli_connect_error());
                exit();
            }
       }
       return self::$mysqli;
    }

    public function mySqli(){
      return self::GetMySqli();
    }

    

}

?>