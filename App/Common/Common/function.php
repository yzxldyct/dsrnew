<?php
function P($a) {
	echo "<pre>";
	print_r($a);
}
function s2m($expiretime){
	if($expiretime >60){
		$data = ($expiretime/60).'分钟';
	}else{
		$data = $expiretime.'秒';
	}
	return $data;
}
//验证码
function check_verify($code, $id = ""){  
    $verify = new \Think\Verify();  
    return $verify->check($code, $id);  
} 

function check_verifymsg($code, $id = ""){  
    $verify = new \Think\Verifymsg();  
    return $verify->check($code, $id);  
}

function gettoken($qyid){
	$map['qyid'] = $qyid;
  $config = M('dsr_config') -> where($map) -> find();
  $appid = $config['appid'];
  $appsecret = $config['appsercet'];
  $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=$appid&corpsecret=$appsecret";
  if($config['tokenextime'] < time()){
  	$data = curlget($url);
  	$a['token'] = $data['access_token'];
  	$token = $a['token'];
  	if($a['token']){
  		$a['tokenextime'] = time() + 7000;
  		$config = M('dsr_config') -> data($a) -> where($map) -> save();
  	}
  }else{
  	$token = $config['token'];
  }
  return $token;
}

function curlget($url){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	$data = json_decode($output,true);
	return $data;
}

function curlpost($url,$data_string) { 
		$curl = curl_init(); 
		curl_setopt($curl, CURLOPT_URL, $url); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE); 
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE); 
		curl_setopt($curl, CURLOPT_POST, 1); 
		curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string); 
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
		$result = curl_exec($curl); 
		//p($result);
		if (curl_errno($curl)) { 
				return 'Errno'.curl_error($curl); 
		} 
		curl_close($curl); 
		return $result; 
}

//获取userid
function getUserid($token,$code) {
	$url="https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=$token&code=$code";
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$url );
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
	curl_setopt($ch, CURLOPT_HEADER, 0);
	$output = curl_exec($ch);
	curl_close($ch);
	$output_array = json_decode($output,true);
	$userid = $output_array['UserId'];
	return $userid;
}


?>