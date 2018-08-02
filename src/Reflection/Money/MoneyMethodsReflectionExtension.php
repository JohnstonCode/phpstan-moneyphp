<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use Money\{Money, Currency};
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;
use PHPStan\Type\ObjectType;

class MoneyMethodsReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if ($classReflection->getName() !== 'Money\Money') {
            return false;
        }

        try {
            $method = $classReflection->getNativeReflection()->getMethod($methodName);

            if (!$method->isStatic()) {
                return true;
            }
        } catch (\Exception $e) {

        }

        $currencies = Currency::getCurrencies();

        return array_key_exists($methodName, $currencies);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $currencies = Currency::getCurrencies();

        if (array_key_exists($methodName, $currencies)) {
            $returnType = new ObjectType('Money\Money');
            return new MoneyMethodReflection($classReflection, $methodName, true, false, $returnType);
        }

        $method = $classReflection->getNativeReflection()->getMethod($methodName);

        return new MoneyMethodReflection($classReflection, $methodName, $method->isStatic(), $method->isPrivate());
    }
}
