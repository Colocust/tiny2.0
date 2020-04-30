<?php


namespace Tiny\Util;

use StdClass;

class Annotation {
  /**
   * @param object $object
   * @return stdClass
   * @throws \ReflectionException
   */
  public function getObjectRules(object $object): stdClass {
    $rules = new stdClass();
    $clazz = new \ReflectionClass($object);
    $properties = $clazz->getProperties();
    foreach ($properties as $property) {
      if (!$property->isPublic()) continue;

      $document = $property->getDocComment();
      $rule = $this->getPropertyRules($document);
      $rules->{$property->getName()} = $rule;
    }
    return $rules;
  }

  /**
   * @param string $annotation
   * @return Rule
   */
  private function getPropertyRules(string $annotation): Rule {
    $rule = new Rule();
    preg_match("/(@var)(.*)(\n)/U", $annotation, $var);
    $rule->type = isset($var[2]) ? trim($var[2]) : "";

    preg_match("/(@uses)(.*)(\n)/U", $annotation, $uses);
    $rule->required = isset($uses[2]) && strstr(trim($uses[2]), 'Required') ? true : false;
    return $rule;
  }
}