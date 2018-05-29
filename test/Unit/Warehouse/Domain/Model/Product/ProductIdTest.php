<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Product;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductIdTest extends TestCase
{
    public function testProductIdCreation()
    {
        $this->assertInstanceOf(ProductId::class, ProductId::fromString(Uuid::uuid4()->toString()));
    }

    public function testItDoesNotCreateFromInteger()
    {
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(ProductId::class, ProductId::fromString(1));
    }

    public function testItDoesNotCreateFromEmptyString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertInstanceOf(ProductId::class, ProductId::fromString(''));
    }
}
