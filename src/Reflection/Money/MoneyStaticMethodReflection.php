<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use PHPStan\Analyser\OutOfClassScope;
use PHPStan\Reflection\ClassMemberReflection;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\FunctionVariant;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Generic\TemplateTypeMap;
use PHPStan\Type\ObjectType;

class MoneyStaticMethodReflection implements MethodReflection
{
    private $classReflection;
    private $name;
    private $callStaticMethod;

    public function __construct(ClassReflection $classReflection, string $name)
    {
        $this->classReflection = $classReflection;
        $this->callStaticMethod = $this->classReflection->getMethod('__callStatic', new OutOfClassScope());
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
                TemplateTypeMap::createEmpty(),
                TemplateTypeMap::createEmpty(),
                [new MoneyStaticParameterReflection()],
                false,
                new ObjectType('Money\Money')
            ),
        ];
    }

    public function getDocComment(): ?string
    {
        return $this->callStaticMethod->getDocComment();
    }

    public function isDeprecated(): \PHPStan\TrinaryLogic
    {
        return $this->callStaticMethod->isDeprecated();
    }

    public function getDeprecatedDescription(): ?string
    {
        return $this->callStaticMethod->getDeprecatedDescription();
    }

    public function isFinal(): \PHPStan\TrinaryLogic
    {
        return $this->callStaticMethod->isFinal();
    }

    public function isInternal(): \PHPStan\TrinaryLogic
    {
        return $this->callStaticMethod->isInternal();
    }

    public function getThrowType(): ?\PHPStan\Type\Type
    {
        return $this->callStaticMethod->getThrowType();
    }

    public function hasSideEffects(): \PHPStan\TrinaryLogic
    {
        return $this->callStaticMethod->hasSideEffects();
    }
}
