<?php
namespace areas\admin\controller;
use areas\admin\model\{UserModel,ConfigModel,MessageModel,RolesModel,UserInfoModel,HtmlModel,MenuModel,CacheModel,LogsModel};
use Dfer\DfPhpCore\Modules\Statics\Mysql;
use Dfer\Tools\Statics\{Common};

class HomeController extends BaseController{

 /**
  * 首页
  * @param {Object} $param
  */
 public function index($param)
 {
  $user = $this->user;
  $hits = ConfigModel::where(['key' => 'hits'])->first()['val'];
  //留言
  $message = MessageModel::where(['status' => 0])->select();
  if ($user->nm == 'df') {
   $where = '1';
   $user->role_name = "超级管理员";
  } else {
   $roles = RolesModel::where($where)->first();
   $user->role_name = $roles['nm'];
   $roles = $roles['roles'];
   $roles = explode('|', $roles);
   foreach ($roles as $v) {
       $str[]= "`id`='{$v}'";
   }
   $where = implode('or',$str);
  }
  $sql = "select * from menu where parent=0 and ({$where}) order by order_num asc";
  $menu = Mysql::run($sql);
  // var_dump($roles,$sql,$menu);
  $this->view(get_defined_vars(),'iconShare');
 }

 /**
  * 生成无限级菜单
  * @param {Object} $data
  * @param {Object} $where
  */
 function menuTree($data,$where){
 foreach($data as $v){
 $v['src']=urldecode($v['src']);
 if(empty($v['src'])){
 echo <<<EOT
 <li>
  <a>
   <i class="fa fa-{$v['type']}"></i><span class="nav-label">{$v['title']}</span><span
    class="fa arrow"></span>
  </a>
  <ul class="nav nav-second-level">
EOT;

   $m =Mysql::run("select * from menu where parent={$v['id']} and ({$where}) order by order_num asc",'sql');
   $this->menuTree($m,$where);
   echo <<<EOT
</ul>
    </li>
EOT;
    } else{
    if(strpos($v['src'],'js:')!==false)
    $src='onclick="'.str_replace('js:','',$v['src']).'"';
    else if(strpos($v['src'],'url:')!==false)
    $src='href="'.str_replace('url:','',$v['src']).'"';
    else $src='href="'.split_url($v['src']).'"';
    echo <<<EOT
<li>
     <a {$src} class="J_menuItem">
      <i class="fa fa-{$v['type']}"></i><span
       class="nav-label">{$v['title']}</span>
     </a>
     </li>
EOT;
     }
     }
}

 /**
  * 退出登陆
  * @param {Object} $param
  */
 public function ext($param)
 {
  cookie_del(session_name());
  session_del(\ENUM::USER_BACK);
  $this->jumpPrompt(1,"admin.login.index");
 }

 /**
  * 起始页
  * @param {Object} $param
  */
 public function desktop($param)
 {
  $this->view(get_defined_vars());
  }



      // ********************** 修改头像 START **********************

      public function changePic($param)
      {
          $output = UserModel::where(1)->first();
          $this->view(get_defined_vars());
      }

      /**
       * 上传头像
       * @param {Object} $param
       */
      public function setChangePic($param)
      {
          $dt = post('data');
          $id = 1;
          $ret = UserModel::where($id)->update($dt);
          $this->jumpPrompt($ret,\ENUM::RELOAD_PARENT);
      }

      /**
       * 上传组件
       * @param {Object} $name
       */
      public function upChangePic($name)
      {
          $rt= Common::uploadFile(Common::UPLOAD_WEB_UPLOADER, ['size'=>"500*500"]);
          // var_dump($rt);die;
          Common::showJsonBase($rt);
      }

      // **********************  修改头像 END  **********************

      // ********************** 设置密码 START **********************

      public function setPwd($param)
      {
          $err = $_GET['err']??null;
          $id = session_get(\ENUM::USER_BACK);
          $id = $id[0];
          $output = UserModel::where($id)->first();
          $this->view(get_defined_vars());
      }

      /**
       * 更新密码
       * @param {Object} $param
       */
      public function updateSetPwd($param)
      {
          $dt = post('data');
          $ndt["pw"] = $dt["npw"];
          $output = UserModel::where($dt['id'])->first();
          if ($output['pw'] != $dt['pw'] || empty($dt['pw'])) {
              // $this->notice('');
              $this->jumpPrompt(false,"set_pwd",'同志，原密码有误');
              // to_url(sprintf("set_pwd"));
          }
          $ret = UserModel::where($dt['id'])->update($ndt);
          $this->jumpPrompt($ret,"set_pwd");
      }

  // **********************  设置密码 END  **********************

 /**
  * 框架信息
  * @param {Object} $param
  */
 public function info($param)
 {
  $this->view(get_defined_vars(),'pure_share');
 }

 // ********************** 用户 START **********************
 public function user($param)
 {
  $output = UserModel::select();
  $this->view(get_defined_vars());
 }

 public function userAdd($param)
 {
  $output = UserModel::where(["id" => $param])->first();
  $type = RolesModel::select();
  // var_dump($param,$output);
  $this->view(get_defined_vars());
 }

 public function userEditUp($name)
 {
  Common::showJsonBase(Common::uploadFile(Common::UPLOAD_UMEDITOR_EDITOR));
 }

 public function userView($param)
 {
  $output = UserModel::where($param)->show();
  $this->view(get_defined_vars());
 }

 //更新数据
 public function userUpdate()
 {
  $dt = post('data');
  $id = post('id');
  $output = UserModel::where(['nm'=>$dt['nm']])->first();

  //新增
  if ($output == null || $id > 0) {
   $dt['last_login_time'] = Common::getTime(TIMESTAMP);
   $ret=UserModel::where($id)->update($dt);
   $this->jumpPrompt($ret,UserModel::getName());
  }
  //修改
  else {
   to_url(str("admin/home/{0}_add", [self::$db_d]), array('err' => '用户已经存在'));
  }
 }

 /**
  * 删除
  * @param {Object} $id
  */
 public function userDel($id)
 {
  if ($id == 1) {
   $this->jumpPrompt(0,UserModel::getName(),'不允许删除此账号');
  }
  $ret = UserModel::where($id)->del();
  $this->jumpPrompt($ret,UserModel::getName());
 }

 // **********************  用户 END  **********************

 // ********************** 权限 START **********************
 public function roles($param)
 {
  $output = RolesModel::select();
  $this->view(get_defined_vars());
 }

 public function rolesAdd($param)
 {
  $err = $_GET['err'];
  $output = RolesModel::where($param)->find();
  $this->view(get_defined_vars());
 }

 public function rolesView($param)
 {
  $output = RolesModel::where($param)->first();
  $this->view(get_defined_vars());
 }

 /**
  * 更新数据
  */
 public function rolesUpdate()
 {
  $dt = post('data');
  $id = post('id');
  $ret = RolesModel::where($id)->update($dt);
  $this->jumpPrompt($ret,RolesModel::getName());
 }

 /**
  * 删除
  * @param {Object} $id
  */
 public function rolesDel($id)
 {
  $ret = RolesModel::where($id)->del();
  $this->jumpPrompt($ret,RolesModel::getName());
 }

 // **********************  权限 END  **********************

 // ********************** 访问信息收集 START **********************

 public function guests($param)
 {
  $output = UserInfoModel::order(['id' => 'desc'])->select();
  $this->view(get_defined_vars());
 }

 // **********************  访问信息收集 END  **********************

// ********************** 静态页面列表 START **********************

 public function html($param)
 {
  $output = HtmlModel::select();
  $this->view(get_defined_vars());
 }

 /**
  * 修改
  * @param {Object} $param
  */
 public function htmlAdd($param)
 {
  $output = HtmlModel::where($param)->find();
  $this->view(get_defined_vars());
 }

 /**
  * 预览
  * @param {Object} $param
  */
 public function htmlView($param)
 {
  $output = HtmlModel::where($param)->first();
  $this->view(get_defined_vars());
 }

 /**
  * 更新
  */
 public function htmlUpdate()
 {
  $dt = post('data');
  $id = post('id');
  $ret = HtmlModel::where($id)->update($dt);
  $this->jumpPrompt($ret,HtmlModel::getName());
 }

 /**
  * 删除
  * @param {Object} $id
  */
 public function htmlDel($id)
 {
  $ret = HtmlModel::where($id)->del();
  $this->jumpPrompt($ret,HtmlModel::getName());
 }

// **********************  静态页面列表 END  **********************

 // ********************** 菜单 START **********************

 public function menu($param)
 {
  $output = MenuModel::where(['parent' => empty($param) ? '0' : $param])->order(['order_num', 'asc'])->select();
  $parent = get('parent');
  $l_parent = explode(',', $parent);
  $l_parent_id = $l_parent[count($l_parent) - 1];
  array_pop($l_parent);
  $l_parent = implode(',', $l_parent);

  $is_df=$this->user->nm=='df'?true:false;
// {:$l_parent_id?showFirst('menu',$l_parent_id)['title']:''}>>{:$param?showFirst('menu',$param)['title']:''}
  $title=str("{0}>>{1}",[$l_parent_id?MenuModel::where($l_parent_id)->find()['title']:'',$param?MenuModel::where($param)->find()['title']:'']);

  $this->view(get_defined_vars());
 }

 public function menuAdd($param)
 {
  $type = array('主页' => 'home', '文件夹' => 'folder', '文件' => 'file', '信息' => 'info', '表格' => 'table', '笔记' => 'book', '用户' => 'user', '用户群' => 'users', '记录' => 'history', '刷新' => 'refresh', '星号' => 'asterisk', '评论' => 'comments', '游戏' => 'gamepad', '链接' => 'link', '音乐' => 'music', '电影' => 'film', '锁' => 'lock', '列表' => 'list', '资金' => 'money', '播放' => 'play', 'bug' => 'bug', '地图' => 'map', '服务' => 'server', '云朵' => 'cloud', '闪电' => 'flash', '代码' => 'code', '旗帜' => 'flag', 'safari' => 'safari', '定位' => 'location-arrow', '保存' => 'save', '男人' => 'male', '女人' => 'female', '设置' => 'gear',);
  if ($param) {
   $output = MenuModel::where($param)->first();
  }
  if (empty($output)) {
   $output = MenuModel::tableInit();
  }
  //		var_dump($output);
  $output['src'] = urldecode($output['src']);

  $parent = $_GET['parent'];
  $parent_id = $_GET['parent_id'];
  $title=str("%s>>>%s",[Common::setVal(MenuModel::where(str_replace(',','',$parent))->find()['title'],""),$output[0]]);
  $this->view(get_defined_vars());
 }

 /**
  * 更新数据
  */
 public function menuUpdate()
 {
  $dt = post('data');
  $dt['parent'] = empty($dt['parent']) ? 0 : $dt['parent'];
  $id = post('id');
  $dt['src'] = urlencode($dt['src']);
  $parent = post('parent');
  $ret = MenuModel::where($id)->update($dt);
  $this->jumpPrompt($ret,str("admin/home/menu/{0}&parent={1}",[$dt['parent'],$parent]));
 }

 /**
  * 删除
  * @param {Object} $id
  */
 public function menuDel($id)
 {
  $parent_id = $_GET['parent_id'];
  $parent = $_GET['parent'];
  $ret = MenuModel::where("id={$id} or parent={$id}")->del();
  $this->jumpPrompt($ret,str("admin/home/menu/{0}&parent={1}",[$parent_id,$parent]));
 }

 // **********************  菜单 END  **********************

/**
 * 调试记录
 * @param {Object} $param
 */
 public function log($param)
 {
  if (!empty(post('clear'))) {
   LogsModel::del();
   show_json(1,'clear');
  }
  $output = LogsModel::select();
  $this->view(get_defined_vars());
 }

 /**
  * 清空服务器缓存
  * @param {Object} $name
  */
 public function freshCache($name)
 {

  //清空数据库缓存
  $db_cache = CacheModel::del();

  //清空文件缓存
  $files_cache = Common::delDir(ROOT . "/data/cache");
  $files_logs = Common::delDir(ROOT . "/data/logs");
  show_json($db_cache, [], $files_cache||$files_logs? '数据库、文件清除成功' : '目录不存在');
 }

/**
 * 生成静态页面
 * 将动态页面转化为静态可以大大提升访问速度，是优化网站的好办法
 * 可以提高网站在搜索引擎的收录率
 *
 * 建议一开始就在后台生成好，保证用户每次访问的都是现成的html页面
 * @param {Object} $param
 */
 public function createStaticPage($param)
 {
  //生成静态页面
  $path = "static_pages";
  Common::mkdirs($path);
  $list = HtmlModel::select();
  $str = '';
  foreach ($list as $i) {
   // var_dump(split_url('homepage/home/'));
   $file_n = str("{0}/{1}/{2}.html", [WEB_ROOT, $path, $i['file_n']]);
   $out = file_get_contents(split_url($i['src']));
   Common::writeFile($out,$file_n);
   $file = str("/{0}/{1}.html", [$path, $i['file_n']]);
   $str .= str("<a href='{file}' target='_blank'>{file}</a>：已生成<br>", ['file'=>$file]);
  }

  //根据主页内的文字生成html页面，用来制作字体
  $body = file_get_contents(split_url('homepage/home/'));
  $body = Common::getChinese($body);

  $path = '/static_pages/font.html';
  $file_n = str("{0}/{1}", [WEB_ROOT, $path]);
  //		echo $file_n;
  $s = sprintf('<html><head><meta charset="UTF-8"><link rel="stylesheet" href="font-awesome.css"></head><body>%s</body></html>', $body);
  Common::writeFile($s,$file_n);
  $str .= str("<a href='{path}' target='_blank'>{path}(用来优化字体文件)</a>：已生成<br>", ['path'=>$path]);
  $this->view(get_defined_vars());
 }


}
