<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Type\Type;
use PHPStan\Type\VoidType;

class MoneyMethodReflection implements MethodReflection
{
    private $classReflection;
    private $name;
    private $static;
    private $private;
    private $return;

    public function __construct(ClassReflection $classReflection, string $name,  bool $static, bool $private, $return = null)
    {
        $this->classReflection = $classReflection;
        $this->name = $name;
        $this->static = $static;
        $this->private = $private;
        $this->return = $return;
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
        return $this->static;
    }

    public function isPrivate(): bool
    {
        return $this->private;
    }

    public function isPublic(): bool
    {
        return !$this->private;
    }

    public function getName(): string
    {
        return $this->name;
    }


    public function getParameters(): array
    {
        return [];
    }

    public function isVariadic(): bool
    {
        return false;
    }

    public function getReturnType()
    {
        return $this->return;
    }

    /**
     * @return \PHPStan\Reflection\ParametersAcceptor[]
     */
    public function getVariants(): array
    {
        return [
            new FunctionVariant(
                [],
                true,
                new VoidType()
            ),
        ];
    }
}
