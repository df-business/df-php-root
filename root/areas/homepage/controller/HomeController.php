<?php
namespace areas\homepage\controller;
use areas\admin\model\{HomeColumnModel,HomeLinkModel,HomeMusicModel,MessageModel,ConfigModel};
use Dfer\DfPhpCore\Modules\Statics\{Mysql,Lang};

class HomeController extends BaseController
{

	/**
		* 首页
		* @param {Object} $param
		*/
	function index($param)
	{
		$home_layout = ConfigModel::where(['key' => 'home_layout'])->value('val');
		$home_column =HomeColumnModel::order(["id" => "asc"])->select();
		$home_link = HomeLinkModel::select();
		$home_music = HomeMusicModel::select();
		// var_dump($home_column);
		//访问量
		Mysql::run("update dt set val=val+1 where `key`='hits'");
		$this->colUserInfo();
		$this->view(get_defined_vars());
	}


	// ********************** 留言 START **********************

	function postMsg()
	{
		$dt = post('data');
		//var_dump($dt);
		$dt["time"] = date("Y-m-d H:i:s");
		$id = 0; //add
		//var_dump($id);die();
		$ret = MessageModel::where($id)->update($dt);
		show_json($ret,null,'留言成功','留言失败');
	}



	// **********************  留言 END  **********************


}

