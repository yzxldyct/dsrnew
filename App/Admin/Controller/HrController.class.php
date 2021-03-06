<?php
namespace Admin\Controller;
use Admin\Controller;
class HrController extends BaseController{
   
    public function index($key=""){
        if($key === ""){
            $model = M('dsr_hr_exam');  
        }else{
            $where['title'] = array('like',"%$key%");
            $model = M('dsr_hr_exam')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new \Think\Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数
        $show = $Page -> show();// 分页显示输出
        $member = $model -> limit($Page->firstRow.','.$Page->listRows) -> where($where) -> order('id') -> select();
        $this->assign('member', $member);
        $this->assign('page',$show);
        $this->display();  

    }

    public function add(){
        if (!IS_POST) {
            $user = session('admin');
            $this -> assign('user',$user);
            $this -> display();
        }
        if (IS_POST) {
            //如果用户提交数据
            p(I());die;
            $data = I('post.');
            $data['password'] = md5(I('post.password'));
            $data['createtime'] = date('Y-m-d H:i:s');
            $model = D("dsr_user");
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

}
