<?php
namespace areas\admin\controller;
use areas\admin\model\{UserModel};

/**
	* 基础类
	*/
abstract class BaseController {

			/**
				* 初始方法
				*/
			public function __construct()
			{
				$this->initialize();
			}

			protected function initialize()
			{
				$this->verifyLogin(1);
			}

/**
	* 视图
	*/
			function view()
			{
				global $_df;
				include_once view("common", $_df['area'], false);
			}


			/**
			 *
			 * 验证登陆
			 * ses里保存了用户的id、nm、pw
			 * @param {Object} $type	0 跳转 1 获取id
			 */
			public function verifyLogin($type = 0)
			{
				global $common;

				$login = get_session(\ENUM::SES_NAME);

				if (!empty($login)) {
					$id = $login[0];
					$nm = $common->hexToStr($login[1]);
					$pw = $common->hexToStr($login[2]);
					if ($type == 'all') {
						return array($id, $nm, $pw);
					}
					// $user = showFirst('df', ['nm' => $nm]);

					$user = UserModel::where(['nm' => $nm])->first();

					if ($user['pw'] == $pw) {
							if ($type) {
								//	var_dump($user['pw'] == $pw);die();
									return $id;
							} else {
									to_url('admin/home/index');
							}
					}
				} else {
						if ($type) {
								to_url('admin/login/index');
						}
						//header("location:?A=admin&c=login");
				}
			}


			/**
			 * wx公众号状态
			 * id不为空就设置缓存
			 * id为空，有缓存就读取缓存，没有就读取wx第一条数据
			 * @param {Object} $id
			 */
			public function wxAc($id = '')
			{
				if (isset($_GET['wx_id'])) {
					return $_GET['wx_id'];
				}
				if ($id != '') {
					set_session('wx', $id);
					return $id;
				}
				$id = get_session('wx');
				if ($id == "") { //缓存不存在就读数据库
					$dt = show("wx", -1);
					$rt = $dt[0][0];
				} else { //存在就直接返回
					$rt = $id;
				}
				return $rt;
			}

}
?>
