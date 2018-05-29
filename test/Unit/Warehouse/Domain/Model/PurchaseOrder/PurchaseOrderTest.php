<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\Supplier\SupplierId;

class PurchaseOrderTest extends TestCase
{
    public function testPurchaseOrderCreation()
    {
        $purchaseOrder = PurchaseOrder::place(
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            SupplierId::fromString(Uuid::uuid4()->toString()),
            [
                Line::create(
                    LineNumber::fromInteger(1),
                    QuantityOrdered::fromInteger(4),
                    QuantityReceived::fromInteger(0),
                    ProductId::fromString(Uuid::uuid4()->toString())
                )
            ]
        );
        $this->assertInstanceOf(PurchaseOrder::class, $purchaseOrder);
    }

    public function testDoesNotCreatePurchaseOrderWithEmptyLines()
    {
        $this->expectException(\Exception::class);
        PurchaseOrder::place(
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            SupplierId::fromString(Uuid::uuid4()->toString()),
            []
        );
    }

    public function testDoesNotCreatePurchaseOrderWithLinesHavingTheSameNumber()
    {
        $this->expectException(\Exception::class);

        $sameLineNumber = LineNumber::fromInteger(1);
        PurchaseOrder::place(
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            SupplierId::fromString(Uuid::uuid4()->toString()),
            [
                Line::create(
                    $sameLineNumber,
                    QuantityOrdered::fromInteger(4),
                    QuantityReceived::fromInteger(0),
                    ProductId::fromString(Uuid::uuid4()->toString())
                ),
                Line::create(
                    LineNumber::fromInteger(1),
                    QuantityOrdered::fromInteger(4),
                    QuantityReceived::fromInteger(0),
                    ProductId::fromString(Uuid::uuid4()->toString())
                ),
            ]
        );
    }

    public function testDoesNotCreatePurchaseOrderWithLinesHavingTheSameProductId()
    {
        $this->expectException(\Exception::class);

        $sameProductId = ProductId::fromString(Uuid::uuid4()->toString());
        PurchaseOrder::place(
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            SupplierId::fromString(Uuid::uuid4()->toString()),
            [
                Line::create(
                    LineNumber::fromInteger(1),
                    QuantityOrdered::fromInteger(4),
                    QuantityReceived::fromInteger(0),
                    $sameProductId
                ),
                Line::create(
                    LineNumber::fromInteger(2),
                    QuantityOrdered::fromInteger(4),
                    QuantityReceived::fromInteger(0),
                    $sameProductId
                ),
            ]
        );
    }
}
