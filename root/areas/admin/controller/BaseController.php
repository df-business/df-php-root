<?php

/**
 * +----------------------------------------------------------------------
 * | 后台基础控制器
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

use areas\admin\model\{UserModel};
use Dfer\Tools\Statics\{Common};
use ENUM;

/**
 * 基础类
 */
abstract class BaseController
{

  protected $user;

  /**
   * 初始方法
   */
  public function __construct()
  {
    $this->initialize();
  }

  protected function initialize()
  {
    $this->verifyAccess();
  }

  /**
   * 视图
   */
  public  function view($params, $template = 'common')
  {
    extract($params);
    // var_dump(func_get_args(),PHP_EOL,get_defined_vars());
    include_once view($template);
  }

  /**
   * 网页跳转的提示页面
   * @param {Object} $var 变量
   **/
  public function jumpPrompt($status = true, $redirect = ENUM::GO_BACK, $msg = "")
  {
    global $_param;
    if (!is_int($redirect)) {
      if (is_array($redirect)) {
        $redirect = split_url($redirect[0], $redirect[1] ?? null, $redirect[2] ?? []);
      } else {
        $redirect = split_url($redirect);
      }
    }
    message(view('message', true), $status, $redirect, $status ? $msg : null, !$status ? $msg : null);
  }

  /**
   * 后台用户登陆验证
   */
  public function verifyAccess()
  {
    //获取后台登录用户的缓存
    $user_cache = session_get(ENUM::USER_BACK);
    if (empty($user_cache)) {
      // 未登录
      to_url('admin/login/index');
    } else {
      // 已登录
      $id = $user_cache['id'];
      // 二进制转字符串
      $nm = Common::hexToStr($user_cache['name']);
      $pw = Common::hexToStr($user_cache['password']);
      $user = UserModel::where($id)->object();
      // var_dump($user,$nm,$pw);
      if ($user->nm == $nm && $user->pw == $pw) {
        // 验证通过
        $this->user = $user;
      } else {
        to_url('admin/login/index');
      }
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
      session_set('wx', $id);
      return $id;
    }
    $id = session_get('wx');
    if ($id == "") { //缓存不存在就读数据库
      $dt = show("wx", -1);
      $rt = $dt[0][0];
    } else { //存在就直接返回
      $rt = $id;
    }
    return $rt;
  }

  const SUCCESS = 'alert-success';
  const ERROR  = 'alert-danger';
  /**
   * 提示
   * @param {Object} $msg 变量
   **/
  public function notice($msg = '...', $type = self::ERROR)
  {
    $html = <<<STR
    <div class="alert {$type}" role="alert">{$msg}</div>
    STR;
    echo $html;
  }

  /**
   * 验证
   * @param {Object} $var 变量
   **/
  public function validate($var = null)
  {
    return new $var;
  }
}
