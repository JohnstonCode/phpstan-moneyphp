<?php declare(strict_types=1);

namespace JohnstonCode\Reflection\Money;

use PHPStan\Reflection\ParametersAcceptorSelector;
use PHPStan\Type\VerbosityLevel;

class MoneyMethodsReflectionExtensionTest extends \PHPStan\Testing\TestCase
{
    private $broker;
    private $extension;

    protected function setUp(): void
    {
        $this->broker = $this->createBroker();
        $this->extension = new MoneyMethodsReflectionExtension();
    }

    public function testHasMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $this->assertTrue($this->extension->hasMethod($classReflection, 'getUnits'));
    }

    public function testHasStaticMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $this->assertTrue($this->extension->hasMethod($classReflection, 'GBP'));
    }

    public function testInvalidMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $this->assertFalse($this->extension->hasMethod($classReflection, 'ZZZ'));
    }

    public function testHasPrivateMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $this->assertTrue($this->extension->hasMethod($classReflection, 'assertSameCurrency'));
    }

    public function testGetPublicMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $methodReflection = $this->extension->getMethod($classReflection, 'getUnits');

        $this->assertEquals('getUnits', $methodReflection->getName());
        $this->assertEquals($classReflection, $methodReflection->getDeclaringClass());
        $this->assertFalse($methodReflection->isStatic());
        $this->assertFalse($methodReflection->isVariadic());
        $this->assertFalse($methodReflection->isPrivate());
        $this->assertTrue($methodReflection->isPublic());
    }

    public function testGetPrivateMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $methodReflection = $this->extension->getMethod($classReflection, 'assertSameCurrency');

        $this->assertEquals('assertSameCurrency', $methodReflection->getName());
        $this->assertEquals($classReflection, $methodReflection->getDeclaringClass());
        $this->assertFalse($methodReflection->isStatic());
        $this->assertFalse($methodReflection->isVariadic());
        $this->assertTrue($methodReflection->isPrivate());
        $this->assertFalse($methodReflection->isPublic());
    }

    public function testGetStaticMethod(): void
    {
        $classReflection = $this->broker->getClass('Money\Money');
        $methodReflection = $this->extension->getMethod($classReflection, 'GBP');
        $parametersAcceptor = ParametersAcceptorSelector::selectSingle($methodReflection->getVariants());

        $this->assertEquals('GBP', $methodReflection->getName());
        $this->assertEquals($classReflection, $methodReflection->getDeclaringClass());
        $this->assertTrue($methodReflection->isStatic());
        $this->assertFalse($methodReflection->isVariadic());
        $this->assertFalse($methodReflection->isPrivate());
        $this->assertTrue($methodReflection->isPublic());
        $this->assertEquals(\Money\Money::class, $parametersAcceptor->getReturnType()->describe(VerbosityLevel::value()));
    }
}
