<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    public function index(){
    	$qyid = I('get.qyid');
    	if($qyid){
	    	$code = I('get.code');
	    	$map['qyid'] = $qyid;
  			$config = M('dsr_config') -> where($map) -> find();
	    	$qyname = $config['qyname'];
	    	$uprow = $config['uprow'];
	    	session('qyname',$qyname);
	    	session('uprow',$uprow);
	    	$token = gettoken($qyid);
				$userid = getUserid($token,$code);
				session('userid',$userid);
				$this -> redirect('realdata',array('qyid' => $qyid));
			}else{
				$this -> error("错误页面");
			}
    }

    public function realdata(){
    	$qyid = I('get.qyid');
    	if($qyid){
	    	$qyname = session('qyname');
				$userid = session('userid');
				$sql = "select c.strsn,d.strname,c.strChannel1Val,c.strChannel2Val,e.Remainmem,e.Totalmem,d.fHumidityLowLimit,d.fTemperatureUpLimit,d.fTemperatureLowLimit,d.fHumidityUpLimit,DATE_FORMAT(c.strdatetime,'%m-%d %H:%i') datetime,c.strdatetime,e.workstate from ".$qyid."_tbl_RemoteUser a inner join ".$qyid."_tbl_RemoteUserEquipmentInfo b on a.strusername=b.strremoteusername inner join ".$qyid."_tbl_EquipmentRealData c on b.strequipmentsn=c.strsn inner join ".$qyid."_tbl_Equipmentinfo d on c.strsn=d.strsn inner join ".$qyid."_tbl_EquipmentState e on c.strsn=e.strsn  where a.strPassword='$userid' or a.strusername='$userid' order by c.strsn";
				$realdata = M() -> query("$sql");
				$this -> assign('realdata',$realdata);
				$this -> realdata -> $realdata;
				$this -> assign('qyname',$qyname);
				$this -> assign('qyid',$qyid);
				$this -> display(realdata);
			}else{
				$this -> error("错误页面");
			}
    }


    public function alarmdata(){
    	$qyid = I('get.qyid');
    	if($qyid){
	    	$qyname = session('qyname');
				$userid = session('userid');	    	
	    	$sql = "select b.strequipmentsn,d.strname,c.strChannel1Val,c.strChannel2Val,DATE_FORMAT(c.strdatetime,'%y-%m-%d %H:%i') datetime,c.strdatetime,c.fTemperatureLowLimit,c.fTemperatureUpLimit,c.fHumidityUpLimit,c.fHumidityLowLimit,c.strSN from ".$qyid."_tbl_RemoteUser a inner join ".$qyid."_tbl_RemoteUserEquipmentInfo b on a.strusername=b.strremoteusername inner join ".$qyid."_tbl_EquipmentAlarmData c on b.strequipmentsn=c.strsn inner join ".$qyid."_tbl_Equipmentinfo d on c.strsn=d.strsn where a.strPassword='$userid' or a.strusername='$userid' order by c.strdatetime desc limit 100";
				$data = M() -> query("$sql");
				$this -> assign('data',$data);
				$this -> data -> $data;
				$this -> assign('qyname',$qyname);
				$this -> assign('qyid',$qyid);
				$this -> display();  
			}else{
				$this -> error("错误页面");
			}  
    }

		public function updata(){
			$qyid = I('get.qyid');
			$userid = session('userid');
			$sql = "show tables like '".$qyid."_tbl_EquipmentInfo_up'";
			$data = M() -> query("$sql");
			$qyname = session('qyname');
			$this -> assign('qyname',$qyname);
			$this -> assign('qyid',$qyid);
			if($qyid && $userid){					
				if($data){
					$uprow = session('uprow');
					$sql = "select a.strsn,a.strname,a.fHumidityLowLimit,a.fTemperatureUpLimit,a.fTemperatureLowLimit,a.fHumidityUpLimit,b.temperature,b.humidity,DATE_FORMAT(b.createtime,'%m-%d %H:%i') createtime from ".$qyid."_tbl_Equipmentinfo a inner join ".$qyid."_tbl_EquipmentInfo_up c on a.strsn=c.sn inner join ".$qyid."_tbl_UploadDataInfo b on c.equipid=b.equipid  where uploadflag='1' order by b.createtime desc,a.strsn asc limit $uprow";
					$data = M() -> query("$sql");
					$this -> assign('data',$data);
					$this -> data -> $data;
					$this -> display();  
				}else{
					$this -> show("<br><br><center><font size=20>上传系统未开启！</font></center>");
				}
			}else{
				$this -> error("错误页面");
			}
		}

}