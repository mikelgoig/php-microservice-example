<?php

declare(strict_types=1);

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use Coduo\PHPMatcher\PHPUnit\PHPMatcherAssertions;
use Zenstruck\Foundry\Test\ResetDatabase;

abstract class ComponentTestCase extends ApiTestCase
{
    use ResetDatabase;
    use PHPMatcherAssertions;
}
