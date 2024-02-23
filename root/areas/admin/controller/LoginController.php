<?php
namespace areas\admin\controller;
use \Dfer\Tools\Files;
use areas\admin\model\{UserModel};
use areas\admin\validate\{LoginValidate};
use Dfer\DfPhpCore\Modules\{Lang,Db};

class LoginController extends BaseController{

	protected function initialize()
	{

	}

    // ********************** 登陆 START **********************
    public function index($param)
    {
        global $other, $_df,$common;
        get_web();
        $this -> verifyLogin();
        //接收post
        if (post('submit')) {
            $user_sm = post['data'];
												$result=LoginValidate::check($user_sm);
												if(!$result->status){
													$this->notice($result->error);
												}
												else{
												$user = UserModel::where(['nm'=>$user_sm['nm']])->first();
            if ($user != null) {
                if ($user["pw"] == $user_sm["pw"] && $user["nm"] == $user_sm["nm"]) {
																				UserModel::where($user[0])->update(array('last_login_time' => $common->getTime(TIMESTAMP)));
																				// 设置session在cookie的保存时间
																				cookie_set(session_name(), session_id(), SESSION_EXPIRES);
                    session_set(\ENUM::SES_NAME, array($user[0], $common->strToHex($user["nm"]),  $common->strToHex($user["pw"])));
																				to_url("admin/home/index");
                }
            }
												$this->notice('同志，请确定你的账号和密码');
												}
        }
								$this->view(get_defined_vars(),'iconShare');
    }

				// **********************  登陆 END  **********************




				/**
				 * 数据库初始化
				 * @param {Object} $var 变量
				 **/
				public function createDb($var = null)
				{
					global $db;
					Db::create($db);
				}


}
