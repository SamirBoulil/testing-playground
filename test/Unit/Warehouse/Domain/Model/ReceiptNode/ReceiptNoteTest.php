<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;

class ReceiptNoteTest extends TestCase
{
    public function testReceiptNoteCreation()
    {
        $receiptNote = ReceiptNote::create(
            ReceiptNoteId::fromString(Uuid::uuid4()->toString()),
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            [
                ReceiptNoteLine::create(
                    ProductId::fromString(Uuid::uuid4()->toString()),
                    QuantityReceived::fromInteger(1)
                )
            ]
        );
        $this->assertInstanceOf(ReceiptNote::class, $receiptNote);
    }

    public function testDoesNotCreatePurchaseOrderWithEmptyLines()
    {
        $this->expectException(\Exception::class);
        ReceiptNote::create(
            ReceiptNoteId::fromString(Uuid::uuid4()->toString()),
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            []
        );
    }

    public function testDoesNotCreatePurchaseOrderWithLinesHavingTheSameProductId()
    {
        $this->expectException(\Exception::class);

        $sameProductId = ProductId::fromString(Uuid::uuid4()->toString());
        ReceiptNote::create(
            ReceiptNoteId::fromString(Uuid::uuid4()->toString()),
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            [
                ReceiptNoteLine::create(
                    $sameProductId,
                    QuantityReceived::fromInteger(1)
                ),
                ReceiptNoteLine::create(
                    $sameProductId,
                    QuantityReceived::fromInteger(1)
                ),
            ]
        );
    }

    public function testRecordEventReceiptNoteCreated()
    {
        $receiptNote = ReceiptNote::create(
            ReceiptNoteId::fromString(Uuid::uuid4()->toString()),
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            [
                ReceiptNoteLine::create(
                    ProductId::fromString(Uuid::uuid4()->toString()),
                    QuantityReceived::fromInteger(1)
                ),
            ]
        );

        $events = $receiptNote->recordedEvents();
        $this->assertEquals(2, count($events));
        $this->assertInstanceOf(ReceiptNoteCreated::class, current($events));
        // TODO: Test more properties

        $this->assertInstanceOf(LineAddedToReceiptNote::class, next($events));
        // TODO: Testsmore properties
    }
}
