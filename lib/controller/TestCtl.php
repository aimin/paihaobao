<?php
namespace controller;
use \sf\Controller;



/**
* 
*/
class TestCtl extends BaseCtl
{
 
    function action(){
        var_dump($_GET);
    }
}



