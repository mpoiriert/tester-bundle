<?php

namespace Draw\Bundle\TesterBundle\PHPUnit\Extension\SetUpAutowire;

use Draw\Component\Core\Reflection\ReflectionExtractor;
use Draw\Component\Tester\PHPUnit\Extension\SetUpAutowire\AutowireInterface;
use PHPUnit\Framework\TestCase;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class AutowireService implements AutowireInterface
{
    use KernelTestCaseAutowireDependentTrait;

    public static function getPriority(): int
    {
        return 0;
    }

    public function __construct(private ?string $serviceId = null)
    {
    }

    public function getServiceId(): ?string
    {
        return $this->serviceId;
    }

    public function autowire(TestCase $testCase, \ReflectionProperty $reflectionProperty): void
    {
        $serviceId = $this->serviceId;

        if (null === $serviceId) {
            $classes = ReflectionExtractor::getClasses($reflectionProperty->getType());

            if (1 !== \count($classes)) {
                throw new \RuntimeException('Property '.$reflectionProperty->getName().' of class '.$testCase::class.' must have a type hint.');
            }

            $serviceId = $classes[0];
        }

        $reflectionProperty->setValue(
            $testCase,
            $this->getContainer($testCase)->get($serviceId)
        );
    }
}
