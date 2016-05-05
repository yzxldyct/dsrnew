<?php
namespace Home\Controller;
use Think\Controller;
class MsgupController extends Controller {

    public function index(){
    	layout(false);
    	$qyid = I('qyid');
    	if($qyid){
    		$map['qyid'] = $qyid;
  			$config = M('dsr_config') -> where($map) -> find();
  			$qyname = $config['qyname'];
  			$touserid = $config['touserid'];
  			$agentid_msgup = $config['agentid'];
  			$token = gettoken($qyid);
	    	$url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=$token"; 
				$sql="select createtime from ".$qyid."_tbl_UploadDataInfo where uploadflag='1' order by createtime desc limit 1";				
				$updata = M() -> query("$sql");
				$time=round((strtotime(date('Y-m-d H:i:s'))-strtotime($updata['0']['createtime']))/60,0);
				$msg=$qyname."：\n你的温湿度上传系统已超过".$time."分钟未上传\n——来自云服务器报警";
				if ($time>35 and $time<2880){
						$txt = array("touser"=>"$touserid","msgtype"=>"text","agentid" =>"$agentid_msgup","text" =>array("content"=>urlencode($msg)));
						$data_string = urldecode(json_encode($txt)); 
						$result = curlpost($url,$data_string);
				}
    }
}

}