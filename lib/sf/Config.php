<?php
namespace sf;
/*
配置读取
 */
class Config 
{
    public static $cfgs = [];
    public static function Get($name){
        if(!isset(self::$cfgs[$name])){
            self::$cfgs[$name] = require_once sprintf("%s/%s.conf.php",CONF_PATH,$name);
        }
        return self::$cfgs[$name];
    }
}
