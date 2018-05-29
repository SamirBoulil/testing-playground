<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class PurchaseOrderIdTest extends TestCase
{
    public function testPurchaseOrderIdCreation()
    {
        $this->assertInstanceOf(PurchaseOrderId::class, PurchaseOrderId::fromString(Uuid::uuid4()->toString()));
    }

    public function testItDoesNotCreateFromInteger()
    {
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(PurchaseOrderId::class, PurchaseOrderId::fromString(1));
    }

    public function testItDoesNotCreateFromEmptyString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertInstanceOf(PurchaseOrderId::class, PurchaseOrderId::fromString(''));
    }

}
