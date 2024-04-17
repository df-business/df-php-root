<?php
namespace areas\admin\controller;
use areas\admin\model\{UserModel};
use Dfer\Tools\Statics\{Common};
/**
 * 基础类
 */
abstract class BaseController {

   /**
    * 初始方法
    */
   function __construct()
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
  public	function view($params,$template='common')
   {
    extract($params);
    // var_dump(func_get_args(),PHP_EOL,get_defined_vars());
    include_once view($template);
   }

   /**
    * 网页跳转的提示页面
    * @param {Object} $var 变量
    **/
   public function jumpPrompt($status=true,$redirect=\ENUM::GO_BACK,$msg="")
   {
    global $_param;
    if(!is_int($redirect)){
     $redirect=split_url($redirect);
     // var_dump($url,$redirect);die;
    }
     message(view('message',true),$status,$redirect,$status?$msg:null,!$status?$msg:null);
   }

   /**
    *
    * 验证登陆
    * ses里保存了用户的id、nm、pw
    * @param {Object} $type	0 跳转 1 获取id
    */
   public function verifyLogin($type = 0)
   {
    $login = session_get(\ENUM::USER_BACK);
    if (!empty($login)) {
     $id = $login[0];
     $nm = Common::hexToStr($login[1]);
     $pw = Common::hexToStr($login[2]);
     if ($type == 'all') {
      return array($id, $nm, $pw);
     }

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

   const SUCCESS='alert-success';
   const ERROR='alert-danger';
   /**
    * 提示
    * @param {Object} $msg 变量
    **/
   public function notice($msg = '...',$type=self::ERROR)
   {
    $html=<<<STR
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
?>
