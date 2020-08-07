<?php declare(strict_types=1);


namespace Tiny\Annotation\Type;


use Tiny\Annotation\Type;

class ArrayType extends Type {

    private $elementType_;

    public function __construct(string $typeName_, Type $elementType) {
        parent::__construct($typeName_);
        $this->elementType_ = $elementType;
    }

    public function isArray(): bool {
        return true;
    }

    public function getElementType(): Type {
        return $this->elementType_;
    }

    public function getElementTypeName(): string {
        return $this->typeName_;
    }


    public function getTypeName(): string {
        return $this->typeName_ . '[]';
    }

}