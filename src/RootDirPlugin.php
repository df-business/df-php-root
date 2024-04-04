<?php

namespace Dfer\DfPhpRoot\Composer;

use Composer\Composer;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;
use Dfer\Tools\Statics\Common;

class RootDirPlugin implements PluginInterface
{
    public function activate(Composer $composer, IOInterface $io)
    {	
        $vendorDir  = $composer->getConfig()->get('vendor-dir');
        $projectRootDir = dirname($vendorDir) . DIRECTORY_SEPARATOR;
        $moduleRootDir    = $vendorDir . DIRECTORY_SEPARATOR . 'dfer' . DIRECTORY_SEPARATOR . 'df-php-root' . DIRECTORY_SEPARATOR . 'root'. DIRECTORY_SEPARATOR;
		
        if (is_dir($moduleRootDir)) {
			echo $moduleRootDir . "	>>>	".$projectRootDir.PHP_EOL;
            echo "////////////////////////////////////////////////// 文件复制 START //////////////////////////////////////////////////".PHP_EOL;
            Common::copyDir($moduleRootDir, $projectRootDir);
            echo "//////////////////////////////////////////////////  文件复制 END  //////////////////////////////////////////////////".PHP_EOL;
			echo PHP_EOL;
			echo "////////////////////////////////////////////////// 文件删除 START //////////////////////////////////////////////////".PHP_EOL;
            Common::deleteDir($moduleRootDir);
			echo "//////////////////////////////////////////////////  文件删除 END  //////////////////////////////////////////////////".PHP_EOL;
        }
    }

    public function deactivate(Composer $composer, IOInterface $io)
    {

    }

    public function uninstall(Composer $composer, IOInterface $io)
    {

    }
}
