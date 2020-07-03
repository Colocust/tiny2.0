<?php declare(strict_types=1);


namespace Tiny\Annotation;


class File {
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

    return trim($matches[2]);
  }

  public function getClass(): ?string {
    preg_match("/(class|trait|interface)(.*)(extends|[\n]{|{|implements)/U", $this->content_, $matches);

    if (empty($matches)) {
      return null;
    }
    if (!isset($matches[2])) {
      return null;
    }

    return trim($matches[2]);
  }
}