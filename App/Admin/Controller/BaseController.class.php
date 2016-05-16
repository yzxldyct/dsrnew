<?php
namespace Admin\Controller;
use Think\Controller;
class BaseController extends Controller {

		public function _initialize(){
  		if(!session('admin')){
        $this -> redirect('Login/index');
    	}
    }
}