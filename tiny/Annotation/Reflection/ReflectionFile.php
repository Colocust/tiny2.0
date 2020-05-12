<?php declare(strict_types=1);


namespace Tiny\Annotation\Reflection;


/**
 *
 * 文件注解器
 *
 * 可获取指定文件中的类名以及命名空间名
 *
 * 只会匹配出一个namespace和class
 *
 * 此处代码不严谨 需要改善
 *
 */
class ReflectionFile {

  private $content_;

  public function __construct(string $dir) {
    if (!is_file($dir)) {
      throw new \Exception($dir . 'not found');
    }
    $this->content_ = file_get_contents($dir);
  }

  public function getNamespace(): ?string {
    preg_match("/(namespace)(.*)(;)/U", $this->content_, $matches);

    if (empty($matches)) {
      return null;
    }
    if (!isset($matches[2])) {
      return null;
    }

    $namespace = trim($matches[2]);
    return $namespace;
  }

  public function getClass(): ?string {
    preg_match("/(class|trait|interface)(.*)(extends|[\n]{|{|implements)/U", $this->content_, $matches);

    if (empty($matches)) {
      return null;
    }
    if (!isset($matches[2])) {
      return null;
    }

    $class = trim($matches[2]);
    return $class;
  }
}
