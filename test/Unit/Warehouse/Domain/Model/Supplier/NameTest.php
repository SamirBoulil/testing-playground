<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Supplier;

use PHPUnit\Framework\TestCase;

class NameTest extends TestCase
{
    public function testNameCreation()
    {
        $this->assertInstanceOf(Name::class, Name::fromString('name'));
    }

    public function testItDoesNotCreateFromInteger()
    {
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(Name::class, Name::fromString(1));
    }

    public function testItDoesNotCreateFromEmptyString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertInstanceOf(Name::class, Name::fromString(''));
    }
}
