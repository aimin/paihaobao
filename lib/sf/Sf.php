<?php
namespace sf;
/*
框架类
 */
class Sf 
{
    //初始化之前检查
    private function init_check(){
        // define('ROOT_PATH',dirname(__FILE__));
        // define('CONF_PATH',sprintf("%s/../%s",ROOT_PATH,"conf"));
        // define('LIB_PATH',sprintf("%s/../%s",ROOT_PATH,"lib"));
        
        $chk_defines = ["ROOT_PATH","CONF_PATH","LIB_PATH"];
        foreach ($chk_defines as $key => $name) {
            if (!defined($name)) {
                throw new Exception("$name undefined!", 1);            
            }
        }
    }

    //初始化
    private function init(){
        $this->init_check();
        $this->setSfAutoLoad();
    }

    //运行
    public function run(){
        $this->init();
    }

    //设置自动加载
    public function setSfAutoLoad(){
        spl_autoload_register(function($class){
            $classname = str_replace("\\", "/", $class);
            $file = sprintf("%s/%s.php",LIB_PATH,$classname);            
            if (is_file($file)){                
                require_once $file;
            }
        });
    }
}
