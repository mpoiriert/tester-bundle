<?php

namespace Draw\Bundle\TesterBundle\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * @internal
 */
class TestCase extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return AppKernel::class;
    }
}
