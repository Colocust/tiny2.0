<?php declare(strict_types=1);

namespace Tiny;


use Tiny\Annotation\Reflection\ReflectionFile;

require_once "tiny/Helper/Time.php";
require_once "tiny/Loader/Loader.php";
require_once "tiny/Annotation/Reflection/ReflectionFile.php";

Loader::register();

define('__ROOT__', __DIR__);
define('EXT', 'php');

/**
 *
 *
 * 敬畏每一行代码
 *
 * 集成器
 *
 * 生成类名与文件路径的映射关系
 *
 *
 */
class Integrator {
  private static $classMap = [];
  private static $filterDirectory = ['.', '..', '.idea'];

  public function go() {
    //第一步 扫描所有文件 生成文件与类的对应关系
    $this->scanDir();

    $file = fopen('__ClassLoader__.php', 'w');
    $classMap = var_export(self::$classMap, true);
    $content = <<<EOF
<?php declare(strict_types=1);

namespace Tiny;

class __ClassLoader__ {
  public const classMap = $classMap;
}
EOF;
    fwrite($file, $content);

  }

  private function scanDir(string $dir = "") {
    $currentDir = __ROOT__;
    if ($dir) {
      $currentDir .= $dir;
    }

    $directories = scandir($currentDir);
    foreach ($directories as $directory) {
      if (in_array($directory, self::$filterDirectory)) {
        continue;
      }

      $current = $currentDir . DIRECTORY_SEPARATOR . $directory;
      $next = $dir . DIRECTORY_SEPARATOR . $directory;

      if (is_file($current)) {
        $this->addClassMap($next);
        continue;
      }
      if (is_dir($current)) {
        $this->scanDir($next);
      }
    }
  }

  private function addClassMap(string $dir) {
    $fileDir = __ROOT__ . $dir;

    $pathInfo = pathinfo($fileDir);
    if (@$pathInfo['extension'] !== EXT) {
      return;
    }

    $fileInstance = new ReflectionFile($fileDir);
    $namespace = $fileInstance->getNamespace();
    $class = $fileInstance->getClass();

    $className = $namespace . '\\' . $class;

    self::$classMap[$className] = $dir;
  }

}

$integrator = new Integrator();
$integrator->go();



