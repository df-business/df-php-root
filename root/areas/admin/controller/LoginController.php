<?php
namespace areas\admin\controller;
use \Dfer\Tools\Files;

class LoginController
{
    // ********************** 登陆 START **********************
    public static $db_d = 'df';
    public function index($param)
    {
        global $other, $_df,$common;
        getWeb();
        $other -> verifyLogin();
        $err="";
        //接收post
        if (isset($_POST['submit'])) {
            $user_sm = $_POST['data'];
            $user = showFirst("df", ['nm'=>$user_sm['nm']]);
            if ($user != null) {
                if ($user["pw"] == $user_sm["pw"] && $user["nm"] == $user_sm["nm"]) {
                    update('df', array('lastlogintime' => $common->getTime(TIMESTAMP)), $user[0]);
																				// 设置session在cookie的保存时间
																				setcookie(session_name(), session_id(), time() + SESSION_EXPIRES, '/');
                    setSession(\Enum::sesName, array($user[0], $common->strToHex($user["nm"]),  $common->strToHex($user["pw"])), "admin/home/index");
                }
            }
            $err="同志，请确定你的账号和密码";
        }
        include viewBack('iconShare');
    }

				// **********************  登陆 END  **********************

				// ********************** 修改头像 START **********************

    public function changePic($param)
    {

        $output = showFirst(self::$db_d, 1);
        include viewBack();
    }

    /**
					* 上传头像
					* @param {Object} $param
					*/
    public function setChangePic($param)
    {
        $dt = $_POST['data'];
        //logs(json_encode($dt) );
        $id = 1;
								// var_dump($dt);
        $myValue = update(self::$db_d, $dt, $id, \Enum::reloadParent);
								// var_dump($myValue);
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
        $id = getSession(\Enum::sesName);
        $id = $id[0];
        $output = showFirst(self::$db_d, $id);
        include viewBack();
    }

    /**
					* 更新密码
					* @param {Object} $param
					*/
    public function updateSetPwd($param)
    {
        global $m, $_df;
        $dt = $_POST['data'];
        $ndt["pw"] = $dt["npw"];
        $output = showFirst(self::$db_d, $dt['Id']);
        if ($output['pw'] != $dt['pw'] || empty($dt['pw'])) {
            toUrl(sprintf("admin/login/setpwd"), array('err' => '原密码有误'));
        }
        update(self::$db_d, $ndt, $dt['Id'], "admin/login/set_pwd");
    }

// **********************  设置密码 END  **********************
}
