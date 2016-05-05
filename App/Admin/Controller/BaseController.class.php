<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {

		public function _initialize(){
  		//echo session('admin');
  		if(!session('admin')){
  			//echo 111;
        $this -> redirect('Login/index');
    	}
    }
}