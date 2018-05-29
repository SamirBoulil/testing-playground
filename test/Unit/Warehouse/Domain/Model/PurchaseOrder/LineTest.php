<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;

class LineTest extends TestCase
{
    public function testLineCreation()
    {
        $this->assertInstanceOf(
            Line::class,
            Line::create(
                LineNumber::fromInteger(1),
                QuantityOrdered::fromInteger(10),
                QuantityReceived::fromInteger(10),
                ProductId::fromString(Uuid::uuid4()->toString())
            )
        );
    }
}
