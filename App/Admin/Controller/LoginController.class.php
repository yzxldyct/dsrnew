<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
    public function index(){
    	layout(false);
    	if(session('admin')){
        $this -> redirect('Index/index');
    	}else{
    		$this -> display();
    	}
        
    }

    public function login(){
			$verify = I('param.c','');  
			if(!check_verify($verify)){  
		  	$this -> error("验证码输错了！",$this -> site_url,3);  
			}  

			$user = I('post.u');
			$password = md5(I('post.p'));

			$map['username'] = $user;
			$map['password'] = $password;
			$this -> check = $check = M("dsr_user") -> where($map) -> find();
			$data = array(
				'username' => $check['username'],
				'logintime' => date('Y-m-d H:i:s'),
				'loginip' => get_client_ip(), 
				);
			if($check){
				session('adminid',$check['id']);
				session('admin',$user);
				M('dsr_user') -> where($map) -> save($data);
				M('dsr_loginlog') -> add($data);
				$this ->redirect('Index/index');
			}else{
				$this ->error('用户名密码错误！');
			}
        
    }

		public function verify(){
				$config = array(
				  'fontSize'    =>    18,    // 验证码字体大小
					'length'      =>    3,     // 验证码位数
					'codeSet' => '0123456789',
					'useNoise'    =>    false, // 关闭验证码杂点
					'expire' => 60,
					//'imageH' => 40,
				);
				$Verify =  new \Think\Verify($config);
				$Verify->entry();
    }

    public function logout(){
    		session('adminid',null);
				session('admin',null);
				layout(false);
        $this -> redirect(index);

    }
}

