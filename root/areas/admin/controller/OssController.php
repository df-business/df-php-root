<?php

/**
 * +----------------------------------------------------------------------
 * | 公开接口
 * |
 * | oss上传回调
 * |
 * | composer require aliyuncs/oss-sdk-php
 * | composer require dfer/tools
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

use areas\admin\model\{OssUploadRecordModel};
use Dfer\Tools\Statics\{Common};
use Dfer\Tools\{AliOss, Constants};
use Exception;

class OssController
{
    public function __construct()
    {
        if (!class_exists('Dfer\Tools\AliOss')) {
            die("缺少`dfer/tools`组件");
        }
    }

    /**
     * oss获取上传参数
     *
     * 配置参数	/data/config/oss.php
     * 请求地址	http://{domain name}/admin/oss/getRequestParams
     *
     * $.ajax({
     *  url: "/admin/oss/getRequestParams/type/ueditor",
     *  type: 'POST',
     *  // 截取视频封面。oss媒体处理样式名称
     *  // data:{process_list:{'cover':['c','jpg']}},
     *  // 加工图片。oss图片处理样式名称（样式里包含了各种参数，比如：http://res.tye3.com/kp_tye3//2024/image/tYGKNP9trMWHR9EQ.jpg?x-oss-process=image/auto-orient,1/resize,m_pad,w_200,h_200）
     *  data:{process_list:{'img_l':null,'img_m':"m",'img_s':"s"}},
     *  success: function(response) {
     *   console.log('Success:', response);
     *  },
     *  error: function(xhr, status, error) {
     *   console.error('Error:', error);
     *  }
     * });
     *
     */
    public function getRequestParams()
    {
        // 组件类型
        $type = post('type', 'ueditor');
        // 资源加工列表
        $process_list = post('process_list', []);

        $access_id =  config('oss.access_id');
        $access_key =  config('oss.access_key');
        $callback_url =  config('oss.callback_url');
        $dir =  config('oss.dir');
        $user_id = $this->userId;
        $debug = 1;
        Common::debug(compact('access_id', 'access_key', 'dir', 'callback_url', 'debug'), false);
        $oss = new AliOss(compact('access_id', 'access_key', 'dir', 'callback_url', 'debug'), false);
        $oss->getRequestParams(compact('user_id', 'type', 'process_list'));
    }


    /**
     * 配置参数	/data/config/oss.php
     * 请求地址	http://{domain name}/admin/oss/uploadCallback
     */
    public function uploadCallback($var = null)
    {
        $access_id =  config('oss.access_id');
        $access_key =  config('oss.access_key');
        $bucket =  config('oss.bucket');
        $endpoint =  config('oss.endpoint');
        $host =  config('oss.host');
        // 调试日志保存在`/data/logs/`
        $debug = 1;
        Common::debug(compact('access_id', 'access_key', 'bucket', 'endpoint', 'host', 'debug'));
        $oss = new AliOss(compact('access_id', 'access_key', 'bucket', 'endpoint', 'host', 'debug'));
        $oss->uploadCallback(function ($status, $data) {
            return $this->callback($status, $data);
        });
    }

    /**
     * 上传回调
     * 可用来添加上传记录
     * @param {Object} $status 状态。true 成功 false 失败
     * @param {Object} $post_arr   上传参数
     */
    public function callback($status, $post_arr)
    {
        if (intval($status)) {
            OssUploadRecordModel::insert([
                'user_id' => $post_arr['user_id'],
                'file_path' => $post_arr['filePath'],
                'url' => $post_arr['host'] . $post_arr['filePath']
            ]);
        }
    }
}
