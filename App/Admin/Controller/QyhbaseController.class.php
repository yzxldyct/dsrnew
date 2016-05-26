<?php
namespace Admin\Controller;
use Admin\Controller;

class QyhbaseController extends BaseController{
 
    public function index(){
        $map['qyid'] = qyh;
        $config = M('dsr_config') -> where($map) -> find();
        $qyid = $config['qyid'];
        $token = gettoken($qyid);
        $url="https://qyapi.weixin.qq.com/cgi-bin/agent/list?access_token=$token";
        $data = curlget($url);
        $agentlist = $data['agentlist'];
        $this -> assign('agentlist',$agentlist);
        $this -> display();
    }
    public function agentinfo(){
        $agentid = I('agentid');
        $map['qyid'] = qyh;
        $config = M('dsr_config') -> where($map) -> find();
        $qyid = $config['qyid'];
        $token = gettoken($qyid);
        $url = "https://qyapi.weixin.qq.com/cgi-bin/agent/get?access_token=$token&agentid=$agentid";
        $agentinfo = curlget($url);
        foreach ($agentinfo as $k => $v) {          
            foreach ($v['partyid'] as $kk => $vv) {    
                $departmentinfoname = getdepartmentinfo($token,$vv);
                //p($departmentinfoname);
                //p($a);
           }
        }
        $this -> assign('departmentinfoname',$departmentinfoname);
        $this -> assign('agentinfo',$agentinfo);      
        $this -> display();
    }
    public function agentmenu(){
        if (!IS_POST) {
            $agentid = I('get.agentid');
            $map['qyid'] = qyh;
            $config = M('dsr_config') -> where($map) -> find();
            $qyid = $config['qyid'];
            $token = gettoken($qyid);
            $url = "https://qyapi.weixin.qq.com/cgi-bin/menu/get?access_token=$token&agentid=$agentid";
            $agentmenu = curlget($url);
            $agentmenu = $agentmenu['menu']['button'];
            p($agentmenu);die;
            $this -> assign('agentmenu',$agentmenu);
            $this->display();
        }
        if (IS_POST) {
            $userinfo = I('post.');
            $userinfo['department'] = array($userinfo['department']);
            $userinfo['department'] = array_slice($userinfo['department'],0,1);
            $userinfo['name'] = urlencode($userinfo['name']);
            p($userinfo);//die;
            p(json_encode($userinfo));die;

            var_dump(urldecode(json_encode($userinfo)));die;
            $map['qyid'] = qyh;
            $config = M('dsr_config') -> where($map) -> find();
            $qyid = $config['qyid'];
            $token = gettoken($qyid);
            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=$token";
            $data_string = urldecode(json_encode($userinfo));
            $result = curlpost($url,$data_string);
            $errcode = json_decode($result)->errcode;
            if ($errcode == 0) {
                $this -> success("用户更新成功", U('Qyhuser/userlist'));       
            }else{
                $this -> error("用户更新失败");
            }
        }
    }








}