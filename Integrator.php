<?php declare(strict_types=1);

namespace Tiny;


use Tiny\Annotation\File;
use Tiny\Http\API;
use Tiny\Annotation\Property;

require_once "tiny/Helper/Time.php";
require_once "tiny/Kernel/Loader.php";
require_once "tiny/Annotation/File.php";

define('__ROOT__', __DIR__);
define('PHP_EXT', 'php');
define('DOC_EXT', 'txt');

class Integrator {
    private static $classMap = [];
    private static $filterDirectory = ['.', '..', '.idea'];

    public function go() {
        $shell = 'rm -rf __ClassLoader__.php';
        shell_exec($shell);
        $shell = 'rm -rf doc';
        shell_exec($shell);
        //第一步 扫描所有文件 生成文件与类的对应关系
        $this->scanDir();

        $file = fopen('__ClassLoader__.php', 'w');
        $classMap = var_export(self::$classMap, true);
        $content =
            '<?php declare(strict_types=1);
namespace Tiny;
        
class __ClassLoader__ {
    public static $classMap = ' . $classMap . ';
}';
        fwrite($file, $content);

        Loader::register();

        //第二步 生成接口文档
        mkdir('doc');
        $this->scanClass();
    }

    private function scanDir(string $dir = ""): void {
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

    private function addClassMap(string $dir): void {
        $fileDir = __ROOT__ . $dir;

        $pathInfo = pathinfo($fileDir);
        if (@$pathInfo['extension'] !== PHP_EXT) {
            return;
        }

        try {
            $file = new File($fileDir);
        } catch (\Exception $e) {
            return;
        }

        $namespace = $file->getNamespace();
        $class = $file->getClass();

        if (is_null($namespace) || is_null($class)) {
            return;
        }

        self::$classMap[$namespace . '\\' . $class] = $dir;
    }

    private function scanClass(): void {
        foreach (self::$classMap as $class => $dir) {
            try {
                $reflectionClass = new \ReflectionClass($class);
            } catch (\ReflectionException $e) {
                continue;
            }

            $class = $reflectionClass;
            do {
                $parentClass = $class->getParentClass();
                if (!$parentClass) {
                    break;
                }
                if ($parentClass->getName() === API::class) {
                    $this->generateInterfaceDoc($reflectionClass);
                    break;
                }
                $class = $parentClass;
            } while (true);
        }
    }

    private function generateInterfaceDoc(\ReflectionClass $reflectionClass): void {
        if ($reflectionClass->isAbstract()) {
            return;
        }
        /**
         * @var $api API
         */
        $api = $reflectionClass->newInstanceWithoutConstructor();

        $docs = ['URL: ' . get_class($api) . PHP_EOL . PHP_EOL];

        $rules = $this->getPropertiesRules($api);
        foreach ($rules as $rule) {
            $docs[] = $rule['name'] . ' {' . PHP_EOL;
            $properties = $rule['properties'];

            /**
             * @var $property Property
             */
            foreach ($properties as $property) {
                $docs[] = "    {$property->getName()} : {$property->getType()->getTypeName()} @{$property->getUses()->getName()}" . PHP_EOL;
            }
            $docs[] = '} ' . PHP_EOL . PHP_EOL;
        }

        $roots = explode('\\', get_class($api));
        array_shift($roots);
        $length = count($roots);
        $dir = 'doc';
        foreach ($roots as $key => $root) {
            $dir .= DIRECTORY_SEPARATOR . $root;
            if ($key == $length - 1) {
                $dir .= '.' . DOC_EXT;
                $file = fopen($dir, 'w');
            }

            if (!file_exists($dir)) {
                mkdir($dir);
            }
        }
        foreach ($docs as $doc) {
            fwrite($file, $doc);
        }
    }

    private function getPropertiesRules(API $api): array {
        $stack = new \SplStack();
        $stack->push($api->responseClass());
        $stack->push($api->requestClass());

        $rules = [];
        while (!$stack->isEmpty()) {
            $reflectionClass = new \ReflectionClass($stack->pop());
            $reflectionProperties = $reflectionClass->getProperties();

            $properties = [];
            foreach ($reflectionProperties as $reflectionProperty) {
                $property = new Property($reflectionProperty);

                $type = $property->getType();
                if ($type->isUserDefinedClass()) {
                    $stack->push($type->getTypeName());
                }
                if ($type->isArray() && $type->getElementType()->isUserDefinedClass()) {
                    $stack->push($type->getElementType()->getTypeName());
                }
                $properties[] = $property;
            }
            $rule['name'] = $reflectionClass->getName();
            $rule['properties'] = $properties;
            $rules[] = $rule;
        }
        return $rules;
    }
}

$integrator = new Integrator();
$integrator->go();
