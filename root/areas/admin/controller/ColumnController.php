<?php
namespace areas\admin\controller;

use Dfer\Tools\Files\Static\{Common};
use areas\admin\model\{HomeLayoutModel,HomeLayoutImgModel,HomeColumnModel,HomeLinkModel,HomeMusicModel,MessageModel,NotepadModel,ColumnModel};

class ColumnController extends BaseController{

	// ********************** 栏目管理 START **********************
	function homeColumn($param) {
		$output = HomeColumnModel::order('asc')->select();
		// var_dump($output);
		$this->view(get_defined_vars());
	}

	function homeColumnAdd($param) {
		$output = HomeColumnModel::where($param)->find();
		$this->view(get_defined_vars());
	}

	function homeColumnUpdate() {
		$dt = post('data');
		$id = post('id');
		$ret = HomeColumnModel::where($id)->update($dt);
		message($ret,"admin/column/" . HomeColumnModel::getName());
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	function homeColumnDel($id) {
		$ret = HomeColumnModel::where($id)->del();
		message($ret,"admin/column/" . HomeColumnModel::getName());
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
		Common::showJsonBase($files->uploadFile(Files::UPLOAD_WEB_UPLOADER));
	}

	// **********************  栏目管理 END  **********************

	// ********************** 留言管理 START **********************
	public function message($param) {
		$output = MessageModel::order(["time"=>'desc'])->select();
		$this->view(get_defined_vars());
	}

	/**
		* 预览
		* @param {Object} $param
		*/
	function messageView($param) {
		$output = MessageModel::where($param)->first();
		MessageModel::where($param)->update(["status"=>true]);
		$this->view(get_defined_vars());
	}

	/**
	 * 删除留言
	 * @param {Object} $id
	 */
	function messageDel($id)
	{
		$ret = MessageModel::where($id)->del();
		message($ret,"homepage/column/" . MessageModel::getName());
	}


	// **********************  留言管理 END  **********************


	// ********************** 链接管理 START **********************

	public function homeLink($param) {
		$output = HomeLinkModel::select();
		$this->view(get_defined_vars());
	}

	function homeLinkAdd($param) {
		$output = HomeLinkModel::where($param)->find();
		$this->view(get_defined_vars());
	}

	function homeLinkUpdate() {
		$dt = post('data');
		$id = post('id');
		$ret = HomeLinkModel::where($id)->update($dt);
		message($ret,"admin/column/" . HomeLinkModel::getName());
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	function homeLinkDel($id) {
		$ret = HomeLinkModel::where($id)->del();
		message($ret,"admin/column/" . HomeLinkModel::getName());
	}

	// **********************  链接管理 END  **********************


	// ********************** 音乐管理 START **********************

	public function homeMusic($param) {
		$output = HomeMusicModel::select();
		$this->view(get_defined_vars());
	}

	function homeMusicAdd($param) {
		$output = HomeMusicModel::where($param)->find();
		$this->view(get_defined_vars());
	}

	function homeMusicUpdate() {
		$dt = post('data');
		$id = post('id');
		$ret = HomeMusicModel::where($id)->update($dt);
		// var_dump($ret);
		message($ret,"admin/column/".HomeMusicModel::getName());
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	function homeMusicDel($id) {
		$ret = HomeMusicModel::where($id)->del();
		message($ret,"admin/column/" . HomeMusicModel::getName());
	}

	// **********************  音乐管理 END  **********************


	// ********************** 布局 START **********************

	function homeLayout($param = 1) {
		$output = HomeLayoutModel::where($param)->first();
		$img = HomeLayoutImgModel::select();
		$this->view(get_defined_vars());
	}

	function homeLayoutUpdate() {
		$dt = post('data');
		$id = post('id');
		// var_dump($_SERVER['HTTP_REFERER']);die;
		$ret = HomeLayoutModel::where($id)->update($dt);
		message($ret,str("admin/column/{0}/1",[HomeLayoutModel::getName()]));
	}

	/**
		* 主页背景图
		* @param {Object} $name
		*/
	function homeLayoutPicUp($name) {
		global $files,$common;
		$dt['img'] = $files->uploadFile(Files::UPLOAD_WEB_UPLOADER);
		HomeLayoutImgModel::insert($dt);
		//不限制尺寸
		$common->showJsonBase($dt['img']);
	}

	function homeLayoutUp($name) {
		global $common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_WEB_UPLOADER,['path'=>VIEW_ASSETS.'/fontFamily/font.TTF']));
	}

	/**
		* 图片删除
		* @param {Object} $name
		*/
	function homeLayoutPicDel($name) {
		global $_param, $files,$common;
		$id = $_param['id'];
		$img = HomeLayoutImgModel::where($id)->first();
		$rt = HomeLayoutImgModel::where($id)->del() . ',';
		$rt .= $files -> delFile($img['img']);
		show_json(1, $rt);
	}

	// **********************  布局 END  **********************


	// ********************** 记事本 START **********************

	public function notepad($param)
	{
		$output = NotepadModel::order(['time', 'desc'])->select();
		$this->view(get_defined_vars());
		}

	/**
		* 修改记事本
		* @param {Object} $param
		*/
	public function notepadAdd($param)
	{
		$output = NotepadModel::where(["id" => $param])->first();
		$this->view(get_defined_vars());
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
		$output = NotepadModel::where(["id" => $param])->first();
		$this->view(get_defined_vars());
		}

	/**
		* 更新数据
		*/
	public function notepadUpdate()
	{
		$dt = post('data');
		$id = post('id');
		// var_dump($_POST);die;
		$ret = NotepadModel::where($id)->update($dt);
		message($ret,str("admin/column/{0}",[NotepadModel::getName()]));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	public function notepadDel($id)
	{
		$ret = NotepadModel::where($id)->del();
		message($ret,str("admin/column/{0}",[NotepadModel::getName()]));
	}


	public function notepadSs($param)
	{
		NotepadModel::showPage(str("admin/column/{0}_ss",[NotepadModel::getName()]));
		$this->view(get_defined_vars());
		}

		/**
			* 修改记事本
			* @param {Object} $param
			*/
		public function notepadSsAdd($param)
		{
			$output = NotepadModel::where(["id" => $param])->first();
			$this->view(get_defined_vars());
			}

			/**
				* 删除
				* @param {Object} $id
				*/
			public function notepadSsDel($id)
			{
				$ret = NotepadModel::where($id)->del();
				message($ret,str("admin/column/{0}_ss",[NotepadModel::getName()]));
			}

			/**
				* 更新数据
				*/
			public function notepadSsUpdate()
			{
				$id = post('id');
				$dt = post('data');
				$ret = NotepadModel::where(["id" => $id])->update($dt);
				message($ret,str("admin/column/{0}_ss",[NotepadModel::getName()]));
			}


		/**
			* 预览记事本
			* @param {Object} $param
			*/
		public function notepadSsView($param)
		{
			$output = NotepadModel::where(["id" => $param])->first();
			$this->view(get_defined_vars());
			}

	// **********************  记事本 END  **********************


	// ********************** 栏目 START **********************

	public function column($param)
	{
		$output = ColumnModel::where(1)->first();
		$this->view(get_defined_vars());
	}

	public function columnUpdate()
	{
		$id = post('id');
		$dt = post('data');
		$ret = ColumnModel::where($id)->update($dt);
		message($ret,str("admin/column/{0}",[ColumnModel::getName()]));
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
		$output = ColumnModel::where(1)->first();
		$this->view(get_defined_vars());
	}
}
?>
