<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use Money\Money;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

class MoneyClassReflectionExtension implements MethodsClassReflectionExtension
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

        $currencies = require __DIR__.'/../../../vendor/moneyphp/money/lib/Money/currencies.php';

        return array_key_exists($methodName, $currencies);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        $isStatic = true;
        $isPrivate = false;
        $isPublic = true;

        try {
            $method = $classReflection->getNativeReflection()->getMethod($methodName);
            $isStatic = $method->isStatic();
            $isPrivate = $method->isPrivate();
            $isPublic = $method->isPublic();
        } catch (\Exception $e) {

        }

        return new MoneyMethodReflection($classReflection, $methodName, $isStatic, $isPrivate, $isPublic);
    }
}
