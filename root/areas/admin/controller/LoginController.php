<?php
namespace areas\admin\controller;
use \Dfer\Tools\Files;
use areas\admin\model\{UserModel};

class LoginController extends BaseController{

	protected function initialize()
	{

	}

    // ********************** 登陆 START **********************
    public static $db_d = 'df';
    public function index($param)
    {
        global $other, $_df,$common;
        get_web();
        $this -> verifyLogin();
        $err="";
        //接收post
        if (isset($_POST['submit'])) {
            $user_sm = $_POST['data'];
												$user = UserModel::where(['nm'=>$user_sm['nm']])->first();
            if ($user != null) {
                if ($user["pw"] == $user_sm["pw"] && $user["nm"] == $user_sm["nm"]) {
																				UserModel::where($user[0])->update(array('last_login_time' => $common->getTime(TIMESTAMP)));
																				// 设置session在cookie的保存时间
																				set_one_cookie(session_name(), session_id(), SESSION_EXPIRES);
                    set_session(\ENUM::SES_NAME, array($user[0], $common->strToHex($user["nm"]),  $common->strToHex($user["pw"])));
																				to_url("admin/home/index");
                }
            }
            $err="同志，请确定你的账号和密码";
        }
        include view_back('iconShare');
    }

				// **********************  登陆 END  **********************

}
