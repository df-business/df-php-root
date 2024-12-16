<?php

/**
 * +----------------------------------------------------------------------
 * | 前端基础控制器
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

namespace areas\homepage\controller;

use areas\admin\model\{UserModel, ConfigModel, MessageModel, RolesModel, UserInfoModel, HtmlModel, MenuModel, CacheModel};

/**
 * 基础类
 */
abstract class BaseController
{

   /**
    * 初始方法
    */
   public function __construct()
   {
      $this->initialize();
   }

   protected function initialize() {}

   /**
    * 视图
    */
   public function view($params, $template = 'common')
   {
      extract($params);
      include_once view($template, param('area'));
   }

   /**
    * 收集用户信息
    */
   public function colUserInfo()
   {
      global $_site;
      $user = UserInfoModel::where(['ip' => IP])->first();
      if ($user) {
         $dt = array('browser' => $_SERVER['HTTP_USER_AGENT'] ?? null, 'hits' => $user['hits'] + 1, 'time' => $_site['time']);
         UserInfoModel::where($user['id'])->update($dt);
      } else {
         $dt = array('ip' => IP, 'browser' => $_SERVER['HTTP_USER_AGENT'], 'hits' => 0, 'first_time' => $_site['time'], 'time' => $_site['time']);
         UserInfoModel::insert($dt);
      }
   }
}
