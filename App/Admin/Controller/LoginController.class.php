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
			if(!check_verifymsg($verify)){  
		  	$this -> error("验证码输错了！",$this -> site_url,1);  
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
				$d = M('dsr_loginlog') -> where($map) -> field('logintime,loginip') -> order('logintime desc') -> find();
				M('dsr_user') -> where($map) -> save($d);
				M('dsr_loginlog') -> add($data);
				$this ->redirect('Index/index');
			}else{
				$this ->error('用户名密码错误！');
			}
        
    }

    public function postverify(){
    		if(IS_AJAX){
    			$config = array(
						'length'  => 4, // 验证码位数
						'codeSet' => '0123456789',
						'expire' => 300,
					);
					$Verify =  new \Think\Verifymsg($config);
					$touserid = I('username');
					$result = $Verify -> postcode($touserid);
					$errcode = json_decode($result)->errcode;
					if ($errcode == 0) {
            $data = "验证码已发送至微信企业号！"; 
            $this -> ajaxReturn($data,'json');    
	    		}else{
	    			$data = "验证码发送失败！"; 
	    			$this -> ajaxReturn($data,'json');  
	    		}
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
				$Verify -> entry();
				p($Verify);die;
    }

    public function logout(){
    		session('adminid',null);
				session('admin',null);
				layout(false);
        $this -> redirect(index);

    }

    public function logincheck(){			
			$user = I('post.username');
			$password = md5(I('post.password'));
			$map['username'] = $user;
			$map['password'] = $password;
			$this -> check = $check = M("dsr_user") -> where($map) -> find();
			if($check){
				$data = 1; 
        $this -> ajaxReturn($data,'json'); 
			}else{
				$data = 0;
				$this -> ajaxReturn($data,'json'); 
			}
    }
}

