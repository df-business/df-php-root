<?php
namespace areas\homepage\controller;
use areas\admin\model\{HomeLayoutModel,HomeColumnModel,HomeLinkModel,HomeMusicModel,MessageModel};
use Dfer\DfPhpCore\Modules\Db;

class HomeController extends BaseController
{

	/**
		* 首页
		* @param {Object} $param
		*/
	function index($param)
	{
		global $other;
		$home_layout = HomeLayoutModel::first();
		$home_column =HomeColumnModel::order(["id" => "asc"])->select();
		$home_link = HomeLinkModel::select();
		$home_music = HomeMusicModel::select();
		//访问量
		Db::sql("update dt set val=val+1 where `key`='hits'");
		$this->colUserInfo();
		include view_front();
	}


	// ********************** 留言 START **********************

	static $db_mes = 'message';
	function postMsg()
	{
		$dt = $_POST['data'];
		//var_dump($dt);
		$dt["time"] = date("Y-m-d H:i:s");
		$id = 0; //add
		//var_dump($id);die();
		$ret = MessageModel::where($id)->update($dt);
		show_json($ret,null,'留言成功','留言失败');
	}



	// **********************  留言 END  **********************


}

