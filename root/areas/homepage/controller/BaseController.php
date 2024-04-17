<?php
namespace areas\homepage\controller;
use areas\admin\model\{UserModel,ConfigModel,MessageModel,RolesModel,UserInfoModel,HtmlModel,MenuModel,CacheModel};
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
   }

  /**
   * 视图
   */
    public	function view($params,$template='common')
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

   /**
    * 发起zfb支付
    * @param {Object} $subject	订单名称
    * @param {Object} $total_amount	付款金额
    * @param {Object} $body	商品描述
    * @param {Object} $config_url	支付对象
    * @param {Object} $para	控制回调页面显示不同的内容
    */
   public function pay($subject, $total_amount, $body, $config_url, $para = 0)
   {
    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = sprintf("Df-%s-%s-%s", TIMESTAMP, rand(), IP);
    session_set('dfOrder', $out_trade_no);
    $config_url = ROOT . sprintf("/module/alipay/%s.php", $config_url);
    $pay_url = ROOT . '/module/alipay/pagepay/pagepay.php';
    require $pay_url;
   }

}
?>
