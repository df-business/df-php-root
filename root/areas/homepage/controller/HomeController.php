<?php
namespace areas\homepage\controller;

class HomeController
{

	/**
		* 首页
		* @param {Object} $param
		*/
	function index($param)
	{
		global $other;
		$home_layout = showFirst("home_layout", ['Id' => 1]);
		$home_column = showList("home_column", [], ["Id" => "asc"]);
		$home_link = showList("home_link");
		$home_music = showList("home_music");

		//var_dump($home_layout);die();
		//访问量
		sql("update dt set val=val+1 where `key`='hits'");
		$other->colUserInfo();

		include viewFront();
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

		$myValue = update(self::$db_mes, $dt, $id);
		showJson($myValue, ($myValue > 0 ? '留言成功' : '留言失败'));
	}


	/**
	 * 删除留言
	 * @param {Object} $id
	 */
	function delPostMsg($id)
	{
		$myValue = del(self::$db_mes, $id, "homepage/column/" . self::$db_mes);
	}

	// **********************  留言 END  **********************


}

