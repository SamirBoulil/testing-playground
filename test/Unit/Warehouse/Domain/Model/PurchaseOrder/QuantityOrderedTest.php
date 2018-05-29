<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use PHPUnit\Framework\TestCase;

class QuantityOrderedTest extends TestCase
{
    public function testQuantityCreation()
    {
        $this->assertInstanceOf(QuantityOrdered::class, QuantityOrdered::fromInteger(10));
    }

    public function testQuantityIsNotNegative()
    {
        $this->expectException(\Exception::class);

        QuantityOrdered::fromInteger(-10);
    }
}
