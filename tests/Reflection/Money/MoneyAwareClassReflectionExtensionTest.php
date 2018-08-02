<?php declare(strict_types=1);

namespace JohnstonCode\Tests;

class MoneyAwareClassReflectionExtensionTest extends \PHPStan\Testing\TestCase
{
    private $broker;
    private $extension;

    protected function setUp(): void
    {
        $this->broker = $this->createBroker();
        $this->extension = new \JohnstonCode\Reflection\Money\MoneyClassReflectionExtension();
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
}
