<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Supplier;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SupplierIdTest extends TestCase
{
    public function testSupplierIdCreation()
    {
        $this->assertInstanceOf(SupplierId::class, SupplierId::fromString(Uuid::uuid4()->toString()));
    }

    public function testItDoesNotCreateFromInteger()
    {
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(SupplierId::class, SupplierId::fromString(1));
    }

    public function testItDoesNotCreateFromEmptyString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertInstanceOf(SupplierId::class, SupplierId::fromString(''));
    }

}
