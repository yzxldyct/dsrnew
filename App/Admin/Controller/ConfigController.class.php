<?php
namespace Admin\Controller;
use Admin\Controller;
class ConfigController extends BaseController{
   
    public function index($key=""){
        if($key === ""){
            $model = M('dsr_config');  
        }else{
            $where['qyid'] = array('like',"%$key%");
            $where['qyname'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = M('dsr_config')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page -> show();// 分页显示输出
        $config = $model -> limit($Page->firstRow.','.$Page->listRows) -> where($where) -> order('id') -> select();
        $this->assign('config', $config);
        $this->assign('page',$show);
        $this->display();     
    }
    public function add(){
        //默认显示添加表单
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $data = I('post.');
            $model = D("dsr_config");
            if (!$model->create()) {
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error($model->getError());
                exit();
            } else {
                if ($model->add($data)) {
                    $this->success("添加成功", U('index'));
                } else {
                    $this->error("添加失败");
                }
            }
        }
    }
    public function update(){
        //默认显示添加表单
        if (!IS_POST) {
            $model = M('dsr_config')->find(I('id',"addslashes"));
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("dsr_config");
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                //验证密码是否为空   
                $data = I();                
                //更新
                if ($model -> save($data)) {
                    $this->success("用户信息更新成功", U('index'));
                } else {
                    $this->error("未做任何修改,用户信息更新失败");
                }        
            }
        }
    }
 
/*    public function delete($id){
    	$id = intval($id);
    	if(C('SUPER_ADMIN_ID') == $id) $this->error("超级管理员不可禁用!");
        $model = M('dsr_user');
        //查询status字段值
        $result = $model->find($id);
        //更新字段
        $data['id']=$id;
        if($result['status'] == 1){
        	$data['status']=0;
        }
        if($result['status'] == 0){
        	$data['status']=1;
        }
        if($model->save($data)){
            $this->success("状态更新成功", U('member/index'));
        }else{
            $this->error("状态更新失败");
        }
    }*/
}
