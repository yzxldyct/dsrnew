<?php
namespace Admin\Controller;
use Think\Controller;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;

class UpController extends Controller{

	public function index(){
		$arr = C("TMPL_PARSE_STRING");
		require "App/Admin/View/Public/qn/autoload.php";//die;
  	// 用于签名的公钥和私钥
	  $accessKey = '0vMKPNQq4HBIkL4WGXqjwPtLKRvL_XqZ7n2lbQO1';
	  $secretKey = '0LmuT-5XLF_zsvBqwLe9Z8tCsvlvqUYpe9GtnMK0';
	  // 初始化签权对象
	  $auth = new Auth($accessKey, $secretKey);
	  $bucket = 'yblog';
	  // 生成上传Token
	  $token = $auth->uploadToken($bucket);
	  $this -> assign('token',$token);
	  $this -> display();

	}

	public function listpic(){
		require "App/Admin/View/Public/qn/autoload.php";
	  $accessKey = '0vMKPNQq4HBIkL4WGXqjwPtLKRvL_XqZ7n2lbQO1';
	  $secretKey = '0LmuT-5XLF_zsvBqwLe9Z8tCsvlvqUYpe9GtnMK0';
		$auth = new Auth($accessKey, $secretKey);
		$bucketMgr = new BucketManager($auth);
		// 要列取的空间名称
		$bucket = 'yblog';
		// 要列取文件的公共前缀
		$prefix = '';
		$marker = '';
		$limit = 30;
		list($iterms, $marker, $err) = $bucketMgr->listFiles($bucket, $prefix, $marker, $limit);
		if ($err !== null) {
		    p($err);
		} else {
				$this -> assign('iterms',$iterms);
				$this -> display();
		    //p($iterms);
		}


	}

}

