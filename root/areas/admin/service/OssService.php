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

namespace areas\admin\service;

use Dfer\Tools\Statics\{Common};
use Dfer\Tools\{AliOss, Constants};

class OssService
{
    protected static $instance;

    private static function instance()
    {
        if (is_null(self::$instance)) {
            $access_id =  config('oss.access_id');
            $access_key =  config('oss.access_key');
            $bucket =  config('oss.bucket');
            $endpoint =  config('oss.endpoint');
            $host =  config('oss.host');
            $dir =  config('oss.dir');
            // 调试日志保存在`/data/logs/`
            $debug = 1;
            Common::debug(compact('access_id', 'access_key', 'bucket', 'endpoint', 'host', 'debug'));
            self::$instance = new AliOss(compact('access_id', 'access_key', 'dir', 'bucket', 'endpoint', 'host', 'debug'));
        }
        return self::$instance;
    }


    /**
     * 保存文件
     * @return mixed
     **/
    public static function saveFileByUrl($url)
    {
        $result = static::instance()->uploadFileOssFromUrl($url);
        return $result;
    }

    /**
     * 保存文件
     * @return mixed
     **/
    public static function saveFileByBase64($base64String)
    {
        $result = static::instance()->uploadFileOssByBase64($base64String);
        return $result;
    }

    public static function deleteFile($src)
    {
        $result = static::instance()->delFileOss($src);
        return $result;
    }
}
