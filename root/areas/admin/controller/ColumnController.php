<?php
namespace areas\admin\controller;

use Dfer\Tools\Files;
class ColumnController {


	// ********************** 栏目管理 START **********************

	static $db_hc = 'home_column';
	function homeColumn($param) {
		global $m;
		$output = showList(self::$db_hc, [],'asc');
		include  viewBack();
	}

	function homeColumnAdd($param) {
		global $m;
		$output = showFirst(self::$db_hc, $param);
		include  viewBack();
	}

	function homeColumnUpdate() {
		global $m;
		$dt = $_POST['data'];
		$id = $_POST['id'];

		$myValue = update(self::$db_hc, $dt, $id, ("admin/column/" . self::$db_hc));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	function homeColumnDel($id) {
		$myValue = del(self::$db_hc, $id, "admin/column/" . self::$db_hc);
	}

	/**
		* 富文本上传组件
		* @param {Object} $name
		*/
	function homeColumnEditUp($name) {
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_UMEDITOR_EDITOR));
	}

	/**
		* 单文件上传组件
		* @param {Object} $name
		*/
	function homeColumnUp($name) {
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_WEB_UPLOADER));
	}

	// **********************  栏目管理 END  **********************

	// ********************** 留言管理 START **********************

	static $db_mes = 'message';
	public function message($param) {
		global $m;
		$output = showList(self::$db_mes,[], ["time"=>'desc']);
		include  viewBack();
	}

	/**
		* 预览
		* @param {Object} $param
		*/
	function messageView($param) {

		$output = showFirst(self::$db_mes, $param);
		update(self::$db_mes, ["status"=>true],$param);
		include  viewBack();
	}

	// **********************  留言管理 END  **********************


	// ********************** 链接管理 START **********************

	static $db_hl = 'home_link';
	public function homeLink($param) {
		global $m;
		$output = showList(self::$db_hl);

		include  viewBack();
	}

	function homeLinkAdd($param) {
		global $m;
		$output = showFirst(self::$db_hl, $param);
		include  viewBack();
	}

	function homeLinkUpdate() {

		global $m;
		$dt = $_POST['data'];
		$id = $_POST['id'];

		$myValue = update(self::$db_hl, $dt, $id, ("admin/column/" . self::$db_hl));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	function homeLinkDel($id) {
		global $m;
		$myValue = del(self::$db_hl, $id, "admin/column/" . self::$db_hl);
	}

	// **********************  链接管理 END  **********************


	// ********************** 音乐管理 START **********************

	static $db_hm = 'home_music';
	public function homeMusic($param) {

		global $m;
		$output = showList(self::$db_hm);
		include  viewBack();
	}

	function homeMusicAdd($param) {
		global $m;

		$output = $param != 0 ? showFirst(self::$db_hm, $param) : "";
		include  viewBack();
	}

	function homeMusicUpdate() {

		global $m;
		$dt = $_POST['data'];
		$id = $_POST['id'];

		$myValue = update(self::$db_hm, $dt, $id, ("admin/column/" . self::$db_hm));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	function homeMusicDel($id) {
		global $m;
		$myValue = del(self::$db_hm, $id, "admin/column/" . self::$db_hm);
	}

	/**
		* 上传组件
		* @param {Object} $name
		*/
	function homeMusicUp($name) {
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_WEB_UPLOADER));
	}

	// **********************  音乐管理 END  **********************


	// ********************** 布局 START **********************

	static $db_hlo = 'home_layout';
	static $db_hli = 'home_layout_img';
	function homeLayout($param = 1) {
		$output = showFirst(self::$db_hlo, $param);
		$img = showList(self::$db_hli);
		//var_dump($img);
		include viewBack();
	}

	function homeLayoutUpdate() {
		$dt = $_POST['data'];
		$id = $_POST['id'];
		$myValue = update(self::$db_hlo, $dt, $id, str("admin/column/{0}/1",[self::$db_hlo]));
	}

	/**
		* 主页背景图
		* @param {Object} $name
		*/
	function homeLayoutPicUp($name) {
		global $files,$common;
		$dt['img'] = $files->uploadFile(Files::UPLOAD_WEB_UPLOADER);
		insert(self::$db_hli, $dt);
		//不限制尺寸
		$common->showJsonBase($dt['img']);
	}

	function homeLayoutUp($name) {
		global $common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_WEB_UPLOADER));
	}

	/**
		* 图片删除
		* @param {Object} $name
		*/
	function homeLayoutPicDel($name) {
		global $_param, $files,$common;
		$id = $_param['id'];
		$img = showFirst(self::$db_hli, $id);
		$rt = del(self::$db_hli, $id) . ',';
		$rt .= $files -> delFile($img['img']);
		$common->showJson(1, $rt);
	}

	// **********************  布局 END  **********************


	// ********************** 记事本 START **********************

	public static $db_n = 'notepad';
	public function notepad($param)
	{
		global $m;
		$output = showList(self::$db_n, [], ['time', 'desc']);
		include viewBack();
		}

	/**
		* 修改记事本
		* @param {Object} $param
		*/
	public function notepadAdd($param)
	{
		global $m;
		$output = showFirst(self::$db_n, ["id" => $param]);
		include viewBack();
		}

	/**
		* 记事本上传组件
		* @param {Object} $name
		*/
	public function notepadEditUp($name)
	{
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_UMEDITOR_EDITOR));
	}

	/**
		* 预览记事本
		* @param {Object} $param
		*/
	public function notepadView($param)
	{
		$output = showFirst(self::$db_n, ["id" => $param]);
		include viewBack();
		}

	/**
		* 更新数据
		*/
	public function notepadUpdate()
	{
		$dt = $_POST['data'];
		$id = $_POST['id'];
		$myValue = update(self::$db_n, $dt, ["id" => $id], str("admin/column/{0}",[self::$db_n]));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	public function notepadDel($id)
	{
		$myValue = del(self::$db_n, $id, str("admin/column/{0}",[self::$db_n]));
	}


	public function notepadSs($param)
	{
		showPage(self::$db_n, [], str("admin/column/{0}_ss",[self::$db_n]));
		include viewBack();
		}

		/**
			* 修改记事本
			* @param {Object} $param
			*/
		public function notepadSsAdd($param)
		{
			global $m;
			$output = showFirst(self::$db_n, ["id" => $param]);
			include viewBack();
			}

			/**
				* 删除
				* @param {Object} $id
				*/
			public function notepadSsDel($id)
			{
				$myValue = del(self::$db_n, $id,  str("admin/column/{0}_ss",[self::$db_n]));
			}

			/**
				* 更新数据
				*/
			public function notepadSsUpdate()
			{
				$dt = $_POST['data'];
				$id = $_POST['id'];
				$myValue = update(self::$db_n, $dt, ["id" => $id], str("admin/column/{0}_ss",[self::$db_n]));
			}


		/**
			* 预览记事本
			* @param {Object} $param
			*/
		public function notepadSsView($param)
		{
			$output = showFirst(self::$db_n, ["id" => $param]);
			include viewBack();
			}

	// **********************  记事本 END  **********************


	// ********************** 栏目 START **********************

	public static $db_c = 'column';
	public function column($param)
	{
		global $m;
		$output = showFirst(self::$db_c, 1);
		include viewBack();
	}

	public function columnUpdate()
	{
		global $m;
		$dt = $_POST['data'];
		$id = $_POST['id'];
		$myValue = update(self::$db_c, $dt, $id, ("admin/column/" . self::$db_c));
	}

	public function columnEditUp($name)
	{
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_UMEDITOR_EDITOR));
	}

	// **********************  栏目 END  **********************

	/**
		* 使用说明
		* @param {Object} $param
		*/
	public function readme($param)
	{
		global $m;
		$output = showFirst(self::$db_c, 1);
		include viewBack();
	}


}
?>
