<?php declare(strict_types=1);


namespace Tiny;


use Tiny\Annotation\Property;
use Tiny\Annotation\Type;
use Tiny\API\HttpStatus;
use Tiny\Exception\ConverterException;

class Converter {

    /**
     * @param \stdClass $from
     * @param object $to
     * @throws ConverterException
     */
    public static function toUserDefinedObject(\stdClass $from, object $to): void {
        try {
            $reflectionClass = new \ReflectionClass($to);
        } catch (\ReflectionException $e) {
            throw new ConverterException($e->getMessage());
        }

        self::toObject($reflectionClass, $from, $to);
    }

    /**
     * @param object $from
     * @return \stdClass
     * @throws ConverterException
     */
    public static function toStdClass(object $from): \stdClass {
        try {
            $reflectionClass = new \ReflectionClass($from);
        } catch (\ReflectionException $e) {
            throw new ConverterException($e->getMessage());
        }

        $to = new \stdClass();

        self::toObject($reflectionClass, $from, $to);
        return $to;
    }

    /**
     * @param \ReflectionClass $reflectionClass
     * @param object $from
     * @param object $to
     * @throws ConverterException
     */
    private static function toObject(\ReflectionClass $reflectionClass, object $from, object $to): void {
        $reflectionProperties = $reflectionClass->getProperties();

        foreach ($reflectionProperties as $reflectionProperty) {
            $property = new Property($reflectionProperty);
            $value = $from->{$reflectionProperty->getName()};

            self::checkPropertyIsRight($value, $property);

            if (is_null($value)) continue;

            if (!self::checkTypeIsRight($value, $property->getType())) {
                throw new ConverterException("变量 {$property->getName()} 类型错误");
            }

            self::convert($value, $property, $to);
        }
    }

    private static function convert($value, Property $property, object $to): void {
        $type = $property->getType();

        if ($type->isArray()) {
            /**
             * @var $type Type\ArrayType
             */
            $to->{$property->getName()} = self::convertArray($value, $type, $property->getName());
            return;
        }

        if ($type->isUserDefinedClass()) {
            /**
             * @var $type Type\UserDefinedType
             */
            $to->{$property->getName()} = self::convertUserDefinedClass($value, $type);
            return;
        }

        $to->{$property->getName()} = $value;
    }

    private static function convertArray(array $value, Type\ArrayType $type, string $op): array {
        $ret = [];

        $elementType = $type->getElementType();
        foreach ($value as $key => $item) {
            if (!self::checkTypeIsRight($item, $elementType)) {
                throw new ConverterException("变量 $op 中的第 $key 个元素类型错误");
            }

            if ($elementType->isArray()) {
                /**
                 * @var $elementType Type\ArrayType
                 */
                $ret[] = self::convertArray($item, $elementType, $op[$key]);
                continue;
            }

            if ($elementType->isUserDefinedClass()) {
                /**
                 * @var $elementType Type\UserDefinedType
                 */
                $ret[] = self::convertUserDefinedClass($item, $elementType);
                continue;
            }

            $ret[] = $item;
        }
        return $ret;
    }

    /**
     * @param object $value
     * @param Type\UserDefinedType $type
     * @return object
     * @throws ConverterException
     * @throws \ReflectionException
     */
    private static function convertUserDefinedClass(object $value, Type\UserDefinedType $type): object {
        $reflectionClass = new \ReflectionClass($type->getTypeName());
        $instance = $reflectionClass->newInstanceWithoutConstructor();

        self::toUserDefinedObject($value, $instance);
        return $instance;
    }

    private static function checkTypeIsRight($value, Type $type): bool {
        if (
            (is_int($value) && $type->isInt()) ||
            (is_float($value) && $type->isFloat()) ||
            (is_string($value) && $type->isString()) ||
            (is_bool($value) && $type->isBool()) ||
            (is_null($value) && $type->isNull()) ||
            (is_array($value) && $type->isArray()) ||
            (is_object($value) && $type->isUserDefinedClass())
        ) {
            return true;
        }
        return false;
    }

    private static function checkPropertyIsRight($value, Property $property) {
        if (is_null($property->getUses()) || is_null($property->getType())) {
            throw new ConverterException("变量 {$property->getName()} 规则定义错误～", HttpStatus::ARGS_ERROR);
        }

        if (is_null($value) && $property->getUses()->isRequired()) {
            throw new ConverterException("变量 {$property->getName()} 为必传参数");
        }
    }
}