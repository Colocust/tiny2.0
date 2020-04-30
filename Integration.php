<?php

namespace Tiny;

use Tiny\Util\Annotation;
use Tiny\Util\Type;
use Tiny\Util\Uses;

define('ext', 'php');

require_once '3rd_party/TinyHelper/Time.php';
require_once "3rd_party/TinyCore/Loader.php";

final class Integration {
  private static $path;
  private static $docExt = 'txt';
  private static $API = 'API\API';
  private static $filterFile = ['.', '..', 'idea'];
  private static $filterCharacter = ')';
  private static $filterClass = [
    'Tiny\\Sms',
    'Tiny\\index'
  ];
  private static $classMap = [];
  private static $delegateMap = [];

  public function __construct() {
    self::$path = __DIR__;
  }

  public function run() {
    echo 'step 1 rm -rf build' . PHP_EOL;
    $startTime = Time::getCurrentMillSecond();
    $shell = "rm -rf build/";
    exec($shell);
    mkdir('build');
    $shell = "rm -rf __ClassLoader__.php";
    exec($shell);
    $endTime = Time::getCurrentMillSecond();
    $costTime = $endTime - $startTime;
    echo "   ---$costTime ms" . PHP_EOL . PHP_EOL;

    echo 'step 2 create class map' . PHP_EOL;
    $startTime = Time::getCurrentMillSecond();
    $this->initFileMap();
    $classLoader = fopen('__ClassLoader__.php', 'a');
    $classMap = var_export(self::$classMap, true);
    $contents = <<<EOF
<?php 
namespace Tiny;
class ClassMap {
  public const classMap = $classMap;
}
EOF;

    fwrite($classLoader, $contents);
    $endTime = Time::getCurrentMillSecond();
    $costTime = $endTime - $startTime;
    echo "   ---$costTime ms" . PHP_EOL . PHP_EOL;

    echo 'step 3 create api doc' . PHP_EOL;
    $startTime = Time::getCurrentMillSecond();
    $this->initByClassMap();
    $endTime = Time::getCurrentMillSecond();
    $costTime = $endTime - $startTime;
    echo "   ---$costTime ms" . PHP_EOL . PHP_EOL;

    $delegateMap = var_export(self::$delegateMap, true);
    $contents = <<<EOF

class DelegateMap {
  public const delegateMap =  $delegateMap;
}
EOF;

    fwrite($classLoader, $contents);
    fclose($classLoader);

    $this->initPhar();

    $shell = "rm -rf __ClassLoader__.php";
    exec($shell);
  }

  private function initFileMap(string $dir = "") {
    $rootPath = self::$path . DIRECTORY_SEPARATOR . $dir;
    $temps = scandir($rootPath);
    foreach ($temps as $temp) {
      if (in_array($temp, self::$filterFile)) {
        continue;
      }
      $absolutePath = $rootPath . $temp;
      $relativePath = $dir . $temp;

      do {
        if (pathinfo($absolutePath, PATHINFO_EXTENSION) === ext) {
          $this->initClassMap($relativePath);
          break;
        }
        if (is_dir($absolutePath)) {
          $this->initFileMap($relativePath . DIRECTORY_SEPARATOR);
        }
        break;
      } while (true);
    }
  }

  private function initClassMap(string $dir) {
    $content = file_get_contents($dir);
    preg_match("/(class|trait|interface)(.*)(extends|[\n]{|{|implements)/U", $content, $class);
    preg_match("/(namespace)(.*)(;)/U", $content, $namespace);
    if (!isset($namespace[2]) || !isset($class[2]) || strstr($class[2], self::$filterCharacter)) {
      return;
    }
    $class = trim($namespace[2]) . '\\' . trim($class[2]);
    self::$classMap[$class] = $dir;
    return;
  }

  private function initDelegateMap($class): void {
    try {
      $clazz = new \ReflectionClass($class);
    } catch (\ReflectionException $e) {
      return;
    }
    $interfaces = $clazz->getInterfaces();
    foreach ($interfaces as $interface => $value) {
      self::$delegateMap[$interface] = $class;
    }
  }

  private function initByClassMap(): void {
    $classMap = ClassMap::classMap;
    foreach ($classMap as $class => $dir) {
      if (in_array($class, self::$filterClass)) {
        continue;
      }
      $this->createInterfaceDocument($class);
      $this->initDelegateMap($class);
    }
  }

  private function createInterfaceDocument(string $class): void {
    $parameterClass = $this->getParameterClass($class);
    if (!$parameterClass) {
      return;
    }
    $file = $this->getDocumentFile($class);
    $this->writeInterfaceDocument($file, $class, $parameterClass);
  }

  private function getParameterClass(string $class): ?array {
    $parameterClass = [];
    $targetClass = $class;
    do {

      try {
        $clazz = new \ReflectionClass($targetClass);
      } catch (\ReflectionException $e) {
        return null;
      }

      //寻找父类
      $parent = $clazz->getParentClass();
      if (!$parent) {
        return null;
      }

      if ($parent->getName() === self::$API) {
        try {
          /**
           * @var $api \API\API
           */
          $api = new $class;

          $parameterClass[] = $api->requestClass()->getName();
          $parameterClass[] = $api->responseClass()->getName();
          return $parameterClass;
        } catch (\Error $error) {
          return null;
        }
      }
      $targetClass = $parent->getName();
    } while ($class);
    return null;
  }

  private function getDocumentFile(string $api) {
    $dir = 'build';
    $roots = explode('\\', $api);
    foreach ($roots as $key => $root) {
      $dir .= DIRECTORY_SEPARATOR . $root;
      if ($key === count($roots) - 1) {
        $dir .= '.' . self::$docExt;
        $file = fopen($dir, 'w');
        break;
      }
      if (!file_exists($dir)) {
        mkdir($dir);
      }
    }
    return $file;
  }

  private function writeInterfaceDocument($file, string $api, array $parameterClass): void {
    $documents = [PHP_EOL . "URL: $api" . PHP_EOL];
    $key = 0;
    do {
      $currentClass = $parameterClass[$key];
      array_push($documents, PHP_EOL . "$currentClass {");

      $rules = $this->getInterfaceRules($currentClass);
      foreach ($rules as $field => $rule) {
        $type = Type::createTypeFromRule($rule->type);
        if ($type->isUserDefinedClass()) {
          $parameterClass[] = $type->getUserDefinedTypeNamespace();
        }
        if ($type->isArray() && $type->getRootType()->isUserDefinedClass()) {
          $parameterClass[] = $type->getRootType()->getUserDefinedTypeNamespace();
        }

        $uses = new Uses($rule->required);
        array_push($documents, PHP_EOL . "  $field : {$type->getName()} {$uses->getValue()};");
      }

      array_push($documents, PHP_EOL . '}' . PHP_EOL);
      $key++;
    } while ($key < count($parameterClass));

    foreach ($documents as $document) {
      fwrite($file, $document);
    }
  }

  private function getInterfaceRules(string $className): ?\stdClass {
    $annotation = new Annotation();
    try {
      $clazz = new \ReflectionClass($className);
      $object = $clazz->newInstanceWithoutConstructor();
      return $annotation->getObjectRules($object);
    } catch (\ReflectionException $e) {
      return null;
    }
  }

  private function initPhar() {
    echo 'step 4 create phar' . PHP_EOL;
    $shell = 'rm -rf main.phar';
    exec($shell);

    $startTime = Time::getCurrentMillSecond();

    $phar = new \Phar("main.phar");
    $phar->buildFromDirectory(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'php');

    $endTime = Time::getCurrentMillSecond();
    $costTime = $endTime - $startTime;
    echo "   ---$costTime ms" . PHP_EOL . PHP_EOL;
  }
}

Loader::register();
$integration = new Integration();
$integration->run();