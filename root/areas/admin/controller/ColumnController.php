<?php

/**
 * +----------------------------------------------------------------------
 * | 后台栏目
 * +----------------------------------------------------------------------
 *                                            ...     .............
 *                                          ..   .:!o&*&&&&&ooooo&; .
 *                                        ..  .!*%*o!;.
 *                                      ..  !*%*!.      ...
 *                                     .  ;$$!.   .....
 *                          ........... .*#&   ...
 *                                     :$$: ...
 *                          .;;;;;;;:::#%      ...
 *                        . *@ooooo&&&#@***&&;.   .
 *                        . *@       .@%.::;&%$*!. . .
 *          ................!@;......$@:      :@@$.
 *                          .@!   ..!@&.:::::::*@@*.:..............
 *        . :!!!!!!!!!!ooooo&@$*%%%*#@&*&&&&&&&*@@$&&&oooooooooooo.
 *        . :!!!!!!!!;;!;;:::@#;::.;@*         *@@o
 *                           @$    &@!.....  .*@@&................
 *          ................:@* .  ##.     .o#@%;
 *                        . &@%..:;@$:;!o&*$#*;  ..
 *                        . ;@@#$$$@#**&o!;:   ..
 *                           :;:: !@;        ..
 *                               ;@*........
 *                       ....   !@* ..
 *                 ......    .!%$! ..     | AUTHOR: dfer
 *         ......        .;o*%*!  .       | EMAIL: df_business@qq.com
 *                .:;;o&***o;.   .        | QQ: 3504725309
 *        .;;!o&****&&o;:.    ..          | WEBSITE: http://www.dfer.site
 * +----------------------------------------------------------------------
 *
 */

namespace areas\admin\controller;

use areas\admin\model\{ConfigModel, LayoutImgModel, ArticleModel, LinkModel, MusicModel, MessageModel, NotepadModel};
use Dfer\Tools\Statics\{Common};

class ColumnController extends BaseController
{

  // ********************** 文章管理 START **********************
  function article($param)
  {
    $output = ArticleModel::order('asc')->select();
    // var_dump($output);
    $this->view(get_defined_vars());
  }

  function articleAdd($param)
  {
    $output = ArticleModel::where($param)->find();
    $this->view(get_defined_vars());
  }

  function articleUpdate()
  {
    $dt = post('data');
    $id = post('id');
    $ret = ArticleModel::where($id)->update($dt);
    $this->jumpPrompt($ret, ArticleModel::getName());
  }

  /**
   * 删除
   * @param {Object} $id
   */
  function articleDel($id)
  {
    $ret = ArticleModel::where($id)->del();
    $this->jumpPrompt($ret, ArticleModel::getName());
  }

  /**
   * 富文本上传组件
   * @param {Object} $name
   */
  function articleEditUp($name)
  {
    Common::showJsonBase(Common::uploadFile(Common::UPLOAD_UMEDITOR_EDITOR));
  }

  /**
   * 单文件上传组件
   * @param {Object} $name
   */
  function articleUp($name)
  {
    Common::showJsonBase(Common::uploadFile(Common::UPLOAD_WEB_UPLOADER));
  }
  // **********************  文章管理 END  **********************

  // ********************** 留言管理 START **********************
  public function message($param)
  {
    $output = MessageModel::order(["time" => 'desc'])->select();
    $this->view(get_defined_vars());
  }

  /**
   * 预览
   * @param {Object} $param
   */
  function messageView($param)
  {
    $output = MessageModel::where($param)->first();
    MessageModel::where($param)->update(["status" => true]);
    $this->view(get_defined_vars());
  }

  /**
   * 删除留言
   * @param {Object} $id
   */
  function messageDel($id)
  {
    $ret = MessageModel::where($id)->del();
    $this->jumpPrompt($ret, MessageModel::getName());
  }
  // **********************  留言管理 END  **********************

  // ********************** 链接管理 START **********************
  public function link($param)
  {
    $output = LinkModel::select();
    $this->view(get_defined_vars());
  }

  function linkAdd($param)
  {
    $output = LinkModel::where($param)->find();
    $this->view(get_defined_vars());
  }

  function linkUpdate()
  {
    $dt = post('data');
    $id = post('id');
    $ret = LinkModel::where($id)->update($dt);
    $this->jumpPrompt($ret, LinkModel::getName());
  }

  /**
   * 删除
   * @param {Object} $id
   */
  function linkDel($id)
  {
    $ret = LinkModel::where($id)->del();
    $this->jumpPrompt($ret, LinkModel::getName());
  }
  // **********************  链接管理 END  **********************

  // ********************** 音乐管理 START **********************
  public function music($param)
  {
    $output = MusicModel::select();
    $this->view(get_defined_vars());
  }

  function musicAdd($param)
  {
    $output = MusicModel::where($param)->find();
    $this->view(get_defined_vars());
  }

  function musicUpdate()
  {
    $dt = post('data');
    $id = post('id');
    $ret = MusicModel::where($id)->update($dt);
    // var_dump($ret);
    $this->jumpPrompt($ret, MusicModel::getName());
  }

  /**
   * 删除
   * @param {Object} $id
   */
  function musicDel($id)
  {
    $ret = MusicModel::where($id)->del();
    $this->jumpPrompt($ret, MusicModel::getName());
  }
  // **********************  音乐管理 END  **********************

  // ********************** 布局 START **********************
  function layout($param)
  {
    $output = ConfigModel::where(['key' => 'layout'])->find()['val'];
    $img = LayoutImgModel::select();
    $this->view(get_defined_vars());
  }

  function layoutUpdate()
  {
    $dt = post('data');
    $id = post('id');
    $ret = ConfigModel::where(['key' => 'layout'])->update(['val' => $dt]);
    $this->jumpPrompt($ret, "layout");
  }

  /**
   * 主页背景图
   * @param {Object} $name
   */
  function layoutPicUp($name)
  {
    $dt['img'] = Common::uploadFile(Common::UPLOAD_WEB_UPLOADER);
    LayoutImgModel::insert($dt);
    //不限制尺寸
    Common::showJsonBase($dt['img']);
  }

  function layoutUp($name)
  {
    Common::showJsonBase(Common::uploadFile(Common::UPLOAD_WEB_UPLOADER, ['path' => VIEW_ASSETS . '/fontFamily/font.TTF']));
  }

  /**
   * 图片删除
   * @param {Object} $name
   */
  function layoutPicDel($name)
  {
    $id = param('id');
    $img = LayoutImgModel::where($id)->first();
    $rt = LayoutImgModel::where($id)->del() . ',';
    $rt .= Common::delFile($img['img']);
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
    Common::showJsonBase(Common::uploadFile(Common::UPLOAD_UMEDITOR_EDITOR));
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
    $this->jumpPrompt($ret, NotepadModel::getName());
  }

  /**
   * 删除
   * @param {Object} $id
   */
  public function notepadDel($id)
  {
    $ret = NotepadModel::where($id)->del();
    $this->jumpPrompt($ret, NotepadModel::getName());
  }


  public function notepadSs($param)
  {
    NotepadModel::showPage(str("admin/column/{0}_ss", [NotepadModel::getName()]));
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
    $this->jumpPrompt($ret, str("{0}_ss", [NotepadModel::getName()]));
  }

  /**
   * 更新数据
   */
  public function notepadSsUpdate()
  {
    $id = post('id');
    $dt = post('data');
    $ret = NotepadModel::where($id)->update($dt);
    $this->jumpPrompt($ret, str("{0}_ss", [NotepadModel::getName()]));
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






}
