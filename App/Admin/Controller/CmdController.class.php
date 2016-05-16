<?php
namespace Admin\Controller;
use Admin\Controller;
class CmdController extends BaseController {

    public function index(){
        $this -> display();
      
    }
    //微信同步
    public function wxtb(){
        $this -> display();
    }
    //备份
    public function back(){
        $this -> display();
    }

    //删除日志
    public function dellog(){
        $this -> display();
    }

    //MSSQL开启curl
    public function sql(){
        $this -> display();
    }
}