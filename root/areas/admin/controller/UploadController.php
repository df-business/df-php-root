<?php
namespace areas\admin\controller;

use Dfer\Tools\Statics\{Common};

class UploadController extends BaseController{

 /**
  * UEDITOR
  * 富文本上传组件
  * @param {Object} $name
  */
 function umeditorUpload($name) {
  Common::showJsonBase(Common::uploadFile(Common::UPLOAD_UMEDITOR_EDITOR,['name'=>'upfile']));
 }

/**
 * WebUploader
 * 文件上传组件
 * @param {Object} $name
 */
 function webUpload($name) {
  Common::showJsonBase(Common::uploadFile(Common::UPLOAD_WEB_UPLOADER));
 }

}
?>
