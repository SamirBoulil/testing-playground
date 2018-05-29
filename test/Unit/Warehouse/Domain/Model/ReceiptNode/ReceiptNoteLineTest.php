<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;

class ReceiptNoteLineTest extends TestCase
{
    public function testReceiptNoteLineCreation()
    {
        $receiptLineNote = ReceiptNoteLine::create(
            ProductId::fromString(Uuid::uuid4()->toString()),
            QuantityReceived::fromInteger(1)
        );
        $this->assertInstanceOf(ReceiptNoteLine::class, $receiptLineNote);
    }
}
