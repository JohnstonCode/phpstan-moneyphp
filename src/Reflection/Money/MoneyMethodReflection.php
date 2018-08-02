<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\Php\DummyParameter;
use PHPStan\Type\CommonUnionType;
use PHPStan\Type\MixedType;
use PHPStan\Type\ObjectType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;

class MoneyMethodReflection implements MethodReflection
{
    private $classReflection;
    private $name;
    private $isStatic;
    private $isPrivate;
    private $isPublic;

    public function __construct(ClassReflection $classReflection, string $name, bool $isStatic, bool $isPrivate, bool $isPublic)
    {
        $this->classReflection = $classReflection;
        $this->name = $name;
        $this->isStatic = $isStatic;
        $this->isPrivate = $isPrivate;
        $this->isPublic = $isPublic;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    public function isStatic(): bool
    {
        return $this->isStatic;
    }

    public function isPrivate(): bool
    {
        return $this->isPrivate;
    }

    public function isPublic(): bool
    {
        return $this->isPublic;
    }

    public function isVariadic(): bool
    {
        return false;
    }

    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return [];
    }
}