<?php
namespace Admin\Controller;
use Admin\Controller;
class SoftController extends BaseController{
   
    public function index($key=""){
        if($key === ""){
            $model = M('dsr_soft');  
        }else{
            $where['softname'] = array('like',"%$key%");
            $model = M('dsr_soft') -> where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page -> show();// 分页显示输出
        $soft = $model -> limit($Page->firstRow.','.$Page->listRows) -> where($where) -> order('id') -> select();
        $this->assign('soft', $soft);
        $this->assign('page',$show);
        $this->display();     
    }

    /**
     * 添加用户
     */
    public function add(){
        //默认显示添加表单
        if (!IS_POST) {
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $data = I('post.');
            $model = D("dsr_soft");
            if (!$model->create()) {
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
            $model = M('dsr_soft')->find(I('id',"addslashes"));
            $this->assign('model',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("dsr_soft");
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                $data = I();
                if ($model -> save($data)) {
                    $this->success("更新成功", U('index'));
                } else {
                    $this->error("更新失败");
                }        
            }
        }
    }
 
    public function delete(){
    	$id = I();
        $model = M('dsr_soft');
        if($model -> where($id) ->delete()){
            $this->success("删除成功", U('index'));
        }else{
            $this->error("删除失败");
        }
    }
}
