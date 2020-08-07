<?php declare(strict_types=1);


namespace Tiny\Annotation;


class Property {

    private $property_;

    public function __construct(\ReflectionProperty $property) {
        $this->property_ = $property;
    }

    public function getType(): ?Type {
        $docComment = $this->property_->getDocComment();
        if (!$docComment) {
            return null;
        }
        preg_match("/(@var)(.*)(\n)/U", $docComment, $matches);
        if (empty($matches)) {
            return null;
        }
        if (!isset($matches[2])) {
            return null;
        }

        return Type::createType($this->property_->getDeclaringClass()->getName(), trim($matches[2]));
    }

    public function getUses(): ?Uses {
        $docComment = $this->property_->getDocComment();
        if (!$docComment) {
            return null;
        }
        preg_match("/(@uses)(.*)(\n)/U", $docComment, $matches);

        if (empty($matches)) {
            return null;
        }
        if (!isset($matches[2])) {
            return null;
        }
        $uses = trim($matches[2]);

        $reflectionClass = new \ReflectionClass($uses);
        if (!$reflectionClass->isSubClassOf(Uses::class)) {
            return null;
        }

        return new $uses;
    }

    public function getName(): string {
        return $this->property_->getName();
    }
}