<?php
namespace areas\admin\controller;
use Dfer\Tools\Files;
use areas\admin\model\{UserModel,ConfigModel,MessageModel,RolesModel,HomeUserInfoModel,HtmlModel,MenuModel,CacheModel};
use Dfer\DfPhpCore\Modules\Db;
class HomeController extends BaseController{

	/**
		* 首页
		* @param {Object} $param
		*/
	public function index($param)
	{
		global $other, $common;
		$id = $this->verifyLogin(1);
		if (!empty($_POST['top-search'])) {
			show_json(true, null, $_POST['top-search']);
		}
		//验证登录
		// $output = showFirst("df", ['id' => $id]);
		$output = UserModel::where(['id' => $id])->first();
		// $hits = showFirst("dt", ['key' => 'hits']);
		$hits = ConfigModel::where(['key' => 'hits'])->first()['val'];
		//留言
		// $message = showList("message", ['status' => 0]);
		$message = MessageModel::where(['status' => 0])->select();
		if ($output['nm'] == 'df') {
			$where = '1';
			$output['role'] = "超级管理员";
		} else {
			$roles = showFirst("roles", $output['role']);
			$output['role'] = $roles['nm'];
			$roles = $roles['roles'];
			$roles = explode('|', $roles);

			foreach ($roles as $v) {
				$role[] = array('id', $v);
			}
			$w = sql_where($role, 'or');
			$where = "{$w}";
		}
		$sql = "select * from menu where parent=0 and ({$where}) order by order_num asc";
		$menu = Db::sql($sql);
		include view_back('iconShare');
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

			$m = \Dfer\DfPhpCore\Modules\Db::sql("select * from menu where parent={$v['id']} and ({$where}) order by order_num asc",'sql');
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
		del_one_cookie(session_name());
		del_session(\ENUM::SES_NAME);
		message(1,"admin/login/index");
	}

	/**
		* 起始页
		* @param {Object} $param
		*/
	public function desktop($param)
	{
		include view_back();
		}



						// ********************** 修改头像 START **********************

		    public function changePic($param)
		    {
										$output = UserModel::where(1)->first();
		        include view_back();
		    }

		    /**
							* 上传头像
							* @param {Object} $param
							*/
		    public function setChangePic($param)
		    {
		        $dt = $_POST['data'];
		        $id = 1;
										$myValue = UserModel::where($id)->update($dt);
										message($ret,\ENUM::reloadParent);
		    }

		    /**
							* 上传组件
							* @param {Object} $name
							*/
		    public function upChangePic($name)
		    {
		        global $files,$common;
		        $rt= $files->uploadFile(Files::UPLOAD_WEB_UPLOADER, ['size'=>"500*500",'path'=>"view/admin/public/assets/img/logo.png"]);
										// var_dump($rt);
										$common->showJsonBase($rt);
		    }

						// **********************  修改头像 END  **********************


		// ********************** 设置密码 START **********************

		    public function setPwd($param)
		    {
		        global $other;
		        $err = $_GET['err']??null;
		        $id = get_session(\ENUM::SES_NAME);
		        $id = $id[0];
										$output = UserModel::where($id)->first();
		        include view_back();
		    }

		    /**
							* 更新密码
							* @param {Object} $param
							*/
		    public function updateSetPwd($param)
		    {
		        $dt = $_POST['data'];
		        $ndt["pw"] = $dt["npw"];
										$output = UserModel::where($dt['id'])->first();
		        if ($output['pw'] != $dt['pw'] || empty($dt['pw'])) {
		            to_url(sprintf("admin/login/set_pwd"), array('err' => '原密码有误'));
		        }
										$ret = UserModel::where($dt['id'])->update($ndt);
										message($ret,str("admin/login/set_pwd"));
		    }

		// **********************  设置密码 END  **********************

	/**
		* 框架信息
		* @param {Object} $param
		*/
	public function info($param)
	{
		global $other;
		$id = $other->verifyLogin(1);
		// var_dump(getenv());
		$df = str(<<<EOT
				<!-- ********************** layui START ********************** -->
				<link href="//unpkg.com/layui@2.8.15/dist/css/layui.css" rel="stylesheet">
				<script src="//unpkg.com/layui@2.8.15/dist/layui.js"></script>
				<!-- **********************  layui END  ********************** -->
				<table class="layui-table" style="width: 50%;">
							<colgroup>
									<col width="35%">
									<col width="65%">
							</colgroup>
							<thead>
									<tr>
											<th colspan="2">框架信息</th>
									</tr>
							</thead>
							<tbody>
									<tr>
											<td>php 当前版本</td>
											<td>{0}</td>
									</tr>
									<tr>
											<td>php 需求版本</td>
											<td>{1}</td>
									</tr>
									<tr>
											<td>DfPHP 当前版本</td>
											<td>{2}</td>
									</tr>

									<tr>
											<td>php 环境</td>
											<td>{3}</td>
									</tr>

							</tbody>
				</table>
				EOT,[PHP_VERSION,PHP_VERSION_MIN,VERSION,getenv('SERVER_SOFTWARE')]);
		die($df);
	}

	// ********************** 用户 START **********************
	public function user($param)
	{
		$output = UserModel::select();
		include view_back();
	}

	public function userAdd($param)
	{
		global $common;
		$err = $_GET['err']??null;
		$output = UserModel::where(["id" => $param])->first();
		$type = RolesModel::select();
		// var_dump($param,$output);
		include view_back();
	}

	public function userEditUp($name)
	{
		global $files,$common;
		$common->showJsonBase($files->uploadFile(Files::UPLOAD_UMEDITOR_EDITOR));
	}

	public function userView($param)
	{
		$output = UserModel::where($param)->show();
		include view_back();
	}

	//更新数据
	public function userUpdate()
	{
		global $common;
		$dt = $_POST['data'];
		$id = $_POST['id'];
		$output = UserModel::where(['nm'=>$dt['nm']])->first();

		//新增
		if ($output == null || $id > 0) {
			$dt['last_login_time'] = $common->getTime(TIMESTAMP);
			UserModel::where($id)->update($dt);
			message($ret,"admin/home/" . UserModel::getName());
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
			message(0, "admin/home/" . UserModel::getName(),null,'不允许删除此账号');
		}
		$ret = UserModel::where($id)->del();
		message($ret,"admin/home/" . UserModel::getName());
	}

	// **********************  用户 END  **********************

	// ********************** 权限 START **********************
	public function roles($param)
	{
		$output = RolesModel::select();
		include view_back();
	}

	public function rolesAdd($param)
	{
		$err = $_GET['err'];
		$output = RolesModel::where($param)->find();
		include view_back();
	}

	public function rolesView($param)
	{
		$output = RolesModel::where($param)->first();
		include view_back();
	}

	/**
		* 更新数据
		*/
	public function rolesUpdate()
	{
		$dt = $_POST['data'];
		$id = $_POST['id'];
		$myValue = RolesModel::where($id)->update($dt,str("admin/home/{0}",[RolesModel::getName()]));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	public function rolesDel($id)
	{
		$myValue = RolesModel::where($id)->del(str("admin/home/{0}",[RolesModel::getName()]));
	}

	// **********************  权限 END  **********************

	// ********************** 访问信息收集 START **********************

	public static $db_guests = 'home_user_info';
	public function guests($param)
	{
		$output = HomeUserInfoModel::order(['id' => 'desc'])->select();
		include view_back();
	}

	// **********************  访问信息收集 END  **********************

// ********************** 静态页面列表 START **********************

	public function html($param)
	{
		$output = HtmlModel::select();
		include view_back();
	}

	/**
		* 修改
		* @param {Object} $param
		*/
	public function htmlAdd($param)
	{
		$output = HtmlModel::where($param)->first();
		include view_back();
	}

	/**
		* 预览
		* @param {Object} $param
		*/
	public function htmlView($param)
	{
		$output = HtmlModel::where($param)->first();
		include view_back();
	}

	/**
		* 更新
		*/
	public function htmlUpdate()
	{
		$dt = $_POST['data'];
		$id = $_POST['id'];
		$myValue = HtmlModel::where($id)->update($dt,str("admin/home/{0}",[HtmlModel::getName()]));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	public function htmlDel($id)
	{
		$myValue = HtmlModel::where($id)->del(str("admin/home/{0}",[HtmlModel::getName()]));
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
		include  view_back();
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

		include view_back();
	}

	/**
		* 更新数据
		*/
	public function menuUpdate()
	{
		$dt = $_POST['data'];
		$dt['parent'] = empty($dt['parent']) ? 0 : $dt['parent'];
		$id = $_POST['id'];
		$dt['src'] = urlencode($dt['src']);
		$parent = $_POST['parent'];
		$myValue = MenuModel::where($id)->update($dt,str("admin/home/menu/{0}&parent={1}",[$dt['parent'],$parent]));
	}

	/**
		* 删除
		* @param {Object} $id
		*/
	public function menuDel($id)
	{
		$parent_id = $_GET['parent_id'];
		$parent = $_GET['parent'];
		$myValue = MenuModel::where("id={$id} or parent={$id}")->del(str("admin/home/menu/{0}&parent={1}",[$parent_id,$parent]));
	}

	// **********************  菜单 END  **********************

/**
	* 调试记录
	* @param {Object} $param
	*/
	public function log($param)
	{
		global $common;
		if (!empty($_POST)) {
			clear('logs');
			show_json(1,'clear');
		}
		$output = LogsModel::select();
		include view_back();
	}

	/**
		* 清空服务器缓存
		* @param {Object} $name
		*/
	public function freshCache($name)
	{
		global $files,$common;

		//清空数据库缓存
		$db_cache = CacheModel::del();

		//清空文件缓存
		$files_cache = $files->delDir(ROOT . "/data/cache");
		$files_logs = $files->delDir(ROOT . "/data/logs");
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
		global $common, $_param, $_df, $files;
		//生成静态页面
		$path = "static_pages";
		$files->mkdirs($path);
		$list = HtmlModel::select();
		$str = '';
		foreach ($list as $i) {
			// $path = $i['file_n'] == 'index' ? '/' : $path;
			$file_n = str("{0}/{1}/{2}.html", [WEB_ROOT, $path, $i['file_n']]);
			//echo $file_n;
			$out = file_get_contents(split_url($i['src']));
			$files->writeFile($out,$file_n);
			$file = str("/{0}/{1}.html", [$path, $i['file_n']]);
			$str .= str("<a href='{file}' target='_blank'>{file}</a>：已生成<br>", ['file'=>$file]);
		}

		//根据主页内的文字生成html页面，用来制作字体
		$body = file_get_contents(split_url('homepage/home'));
		$body = $common->getChinese($body);

		$path = '/static_pages/font.html';
		$file_n = str("{0}/{1}", [WEB_ROOT, $path]);
		//		echo $file_n;
		$s = sprintf('<html><head><meta charset="UTF-8"><link rel="stylesheet" href="font-awesome.css"></head><body>%s</body></html>', $body);
		$files->writeFile($s,$file_n);
		$str .= str("<a href='{path}' target='_blank'>{path}(用来优化字体文件)</a>：已生成<br>", ['path'=>$path]);
		include view_back();
	}


	/**
	 * 创建数据库
	 * @param {Object} $var 变量
	 **/
	public function createDb($var = null)
	{
		global $other,$db;
		$other->createDb($db);
	}

}
