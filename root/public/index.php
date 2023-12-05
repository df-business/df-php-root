<?php
namespace Dfer\DfPhpCore\Modules;

// 加载基础文件
require dirname(__DIR__) . '/vendor/autoload.php';

(new Web())->run();
