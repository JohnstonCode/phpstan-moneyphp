<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use Money\Currency;
use Money\Currencies\ISOCurrencies;
use Money\Currencies\BitcoinCurrencies;
use PHPStan\Reflection\ClassReflection;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Reflection\MethodsClassReflectionExtension;

class MoneyMethodsReflectionExtension implements MethodsClassReflectionExtension
{
    public function hasMethod(ClassReflection $classReflection, string $methodName): bool
    {
        if ($classReflection->getName() !== 'Money\Money') {
            return false;
        }

        if (method_exists('Money\Currency', 'getCurrencies')) {
            $currencies = Currency::getCurrencies();

            return array_key_exists($methodName, $currencies);
        }

        $currency = new Currency($methodName);
        $ISOcurrencies = new ISOCurrencies();
        $bitcoinCurrencies = new BitcoinCurrencies();

        return $ISOcurrencies->contains($currency) || $bitcoinCurrencies->contains($currency);
    }

    public function getMethod(ClassReflection $classReflection, string $methodName): MethodReflection
    {
        return new MoneyStaticMethodReflection($classReflection, $methodName);
    }
}
