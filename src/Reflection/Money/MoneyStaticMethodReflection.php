<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Type\Type;
use PHPStan\Type\ObjectType;
use PHPStan\Type\IntegerType;

class MoneyStaticMethodReflection implements MethodReflection
{
    private $classReflection;
    private $name;

    public function __construct(ClassReflection $classReflection, string $name)
    {
        $this->classReflection = $classReflection;
        $this->name = $name;
    }

    public function getDeclaringClass(): ClassReflection
    {
        return $this->classReflection;
    }

    public function getPrototype(): ClassMemberReflection
    {
        return $this;
    }

    public function isStatic(): bool
    {
        return true;
    }

    public function isPrivate(): bool
    {
        return false;
    }

    public function isPublic(): bool
    {
        return true;
    }

    public function getName(): string
    {
        return $this->name;
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
        return [
            new FunctionVariant(
                [new MoneyStaticParameterReflection()],
                false,
                new ObjectType('Money\Money')
            ),
        ];
    }
}