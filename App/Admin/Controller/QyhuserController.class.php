<?php
namespace Admin\Controller;
use Admin\Controller;

class QyhuserController extends BaseController{
 
    public function index(){
        $map['qyid'] = qyh;
        $config = M('dsr_config') -> find($map);
        $token = gettoken($qyid);
        $url="https://qyapi.weixin.qq.com/cgi-bin/agent/list?access_token=$token";
        $data = curlget($url);
        $agentlist = $data['agentlist'];
        //$agentlist = getagentlist($token);
        $this -> assign('agentlist',$agentlist);
        $this -> display();
    }

    public function userlist(){
        $map['qyid'] = 'qyh';
        $config = M('dsr_config') -> where($map) -> find();
        $qyid = $config['qyid'];
        $token = gettoken($qyid);
        $department_id = '1';
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token=$token&department_id=$department_id&fetch_child=1&status=0";
        $data = curlget($url);
        //p($data);die;
        $userlist = $data['userlist'];
        //$userlist = multi2one($userlist);
        // foreach ($userlist as $k => $v) {
        //     //$v= department;
        //     //p($v['department']);
        //     $department = $v['department'];
        //     ///p($department);
            
        //     //p($departmentname);die;
        //     //die;
        //     //$agentlist = $data['agentlist'];
        //     //$this -> assign('department',$department);
        // } 
        //
        //p($userlist);die;
        //p($departmentname);die;
        //$this -> assign('departmentname',$departmentname);
        $this -> assign('userlist',$userlist);
        $this -> display();
    }

    public function adduser(){
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            $userinfo = I('post.');
            $userinfo['department'] = array($userinfo['department']);
            $map['qyid'] = qyh;
            $config = M('dsr_config') -> where($map) -> find();
            $qyid = $config['qyid'];
            $token = gettoken($qyid);
            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=$token";
            $data_string = json_encode($userinfo);
            $result = curlpost($url,$data_string);
            $errcode = json_decode($result)->errcode;
            if ($errcode == 0) {
                $this -> success("用户添加成功", U('Qyhuser/userlist'));       
            }else{
                $this -> error("用户添加失败");
            }
        }
    }
   
    public function deluser(){
        $userid = I('get.userid');
        $map['qyid'] = qyh;
        $config = M('dsr_config') -> where($map) -> find();
        $qyid = $config['qyid'];
        $token = gettoken($qyid);
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=$token&userid=$userid";
        $data_string = json_encode($userinfo);
        $result = curlpost($url,$data_string);
        $errcode = json_decode($result)->errcode;
        if ($errcode == 0) {
            $this -> success("用户删除成功", U('Qyhuser/userlist'));       
        }else{
            $this -> error("用户删除失败");
        }
    }
    public function update(){
    //默认显示添加表单
        if (!IS_POST) {
            $userid = I('get.userid');
            $map['qyid'] = qyh;
            $config = M('dsr_config') -> where($map) -> find();
            $qyid = $config['qyid'];
            $token = gettoken($qyid);
            $url = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=$token&userid=$userid";
            $userinfo = curlget($url);
            //p($data);die;
            $this -> assign('userinfo',$userinfo);
            $this->display();
        }
        if (IS_POST) {
            $userinfo = I('post.');
            $userinfo['department'] = array($userinfo['department']);
            $userinfo['department'] = array_slice($userinfo['department'],0,1);
            //$userinfo['department'] = array_slice($userinfo['department'],0);
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
            //p($data_string);die;
            $result = curlpost($url,$data_string);
            $errcode = json_decode($result)->errcode;
            if ($errcode == 0) {
                $this -> success("用户更新成功", U('Qyhuser/userlist'));       
            }else{
                $this -> error("用户更新失败");
            }
        }
    }

    public function test(){
        $map['qyid'] = qyh;
        $config = M('dsr_config') -> find($map);
        $token = gettoken($qyid);
        $url = "https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=$token";
        $txt = array("userid"=>"13777497323","name"=>"yzx","department" =>[2,4,5,6],"mobile" =>"13777497323");
        $data_string = urldecode(json_encode($txt)); 
        $result = curlpost($url,$data_string);
        $errcode = json_decode($result)->errcode;
        if ($errcode == 0) {
            $this -> success("用户更新成功", U('Qyhuser/userlist'));       
        }else{
            $this -> error("用户更新失败");
        }
    }






}