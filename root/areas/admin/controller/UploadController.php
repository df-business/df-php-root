<?php
namespace areas\admin\controller;

use Dfer\Tools\Files;
use areas\admin\model\{HomeLayoutModel,HomeLayoutImgModel,HomeColumnModel,HomeLinkModel,HomeMusicModel,MessageModel,NotepadModel,ColumnModel};

class UploadController extends BaseController{

	/**
		* UEDITOR
		* 富文本上传组件
		* @param {Object} $name
		*/
	function umeditorUpload($name) {
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_UMEDITOR_EDITOR,['name'=>'upfile']));
	}

/**
	* WebUploader
	* 文件上传组件
	* @param {Object} $name
	*/
	function webUpload($name) {
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_WEB_UPLOADER));
	}

}
?>
