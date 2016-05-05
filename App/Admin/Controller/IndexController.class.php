<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends BaseController {

    public function index(){
      layout(false);
			$count  = M('dsr_user') ->count();
			$this->assign('count', $count);
    	$this -> display();
      
    }
    
}