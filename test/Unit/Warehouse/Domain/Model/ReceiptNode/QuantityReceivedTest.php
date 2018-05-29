<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use PHPUnit\Framework\TestCase;

class QuantityReceivedTest extends TestCase
{
    public function testQuantityCreation()
    {
        $this->assertInstanceOf(QuantityReceived::class, QuantityReceived::fromInteger(10));
    }

    public function testQuantityIsNotNegative()
    {
        $this->expectException(\Exception::class);

        QuantityReceived::fromInteger(-10);
    }
}
