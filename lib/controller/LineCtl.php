<?php
namespace controller;
use \sf\Controller;
use \paihao\User ;
use \paihao\Line;



/**
* 
*/
class LineCtl extends BaseCtl
{   
    //排号添加
    function add(){
        $lname = $_REQUEST['lname'];
        $to_tip = $_REQUEST['to_tip'];
        $close_tip = $_REQUEST['close_tip'];
        $uid = $this->getReqestHeader('uid');

        $u = new User($uid);
        $mgl = $u->GetMgline();

        $info['uid']=$uid;
        $info['lname']=$lname;
        $info['to_tip']=$to_tip;
        $info['close_tip']=$close_tip;

        //创建一个排号
        $line = $mgl->CreateLine($info);          
        if($line){
            $this->outjson($line->Get());     
        }else{
            $this->error('50001');
        }
        exit;
    }

    //列表排号
    function list(){
        $uid = $this->getReqestHeader('uid');
        $u = new User($uid);
        $mgl = $u->GetMgline();
        $rows = $mgl->MyLaunchedLineList(0,10);
        $this->outjson($rows);
    }

    //排号详情
    function detail(){
        $lid = $_REQUEST['lid'];
        $line = new Line($lid);        
        $detail = $line->InLineDetail();
        $this->outjson($detail);
    }

    //开始
    function start(){
        $lid = $_REQUEST['lid'];
        $line = new Line($lid);
        $inlineid = $line->StartLine();
        if(!$inlineid){
            $this->error('29003');
        }

        $InLineDetail = $line->InLineDetail();
        $this->outjson($InLineDetail);
    }

    //停止
    function stop(){
        $lid = $_REQUEST['lid'];
        $line = new Line($lid);
        $bool = $line->StopLine();
        if(!$bool){
            $this->error('29003');
        }
        $this->outjson(true);
    }

}



