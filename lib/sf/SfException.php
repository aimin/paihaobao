<?php
namespace sf;
/*
异常类
 */
class SfException extends \Exception
{
    public static function Throw($code){                      
        throw new \sf\SfException(\sf\Config::Get('err')[$code],$code);
    }
}
