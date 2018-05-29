<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;


use Common\EventDispatcher\EventDispatcher;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteId;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteLine;

class ReceiptNoteRepositoryTest extends TestCase
{

    public function testSavesAndReturnsAReceiptNote()
    {
        $eventDispatcher = new EventDispatcher();
        $repository = new InMemoryReceiptNoteRepository($eventDispatcher);
        $receiptNoteId = ReceiptNoteId::fromString(Uuid::uuid4()->toString());
        $expectedReceiptNote = ReceiptNote::create(
            $receiptNoteId,
            PurchaseOrderId::fromString(Uuid::uuid4()->toString()),
            [
                ReceiptNoteLine::create(
                    ProductId::fromString(Uuid::uuid4()->toString()),
                    QuantityReceived::fromInteger(1)
                ),
            ]
        );

        $repository->save($expectedReceiptNote);
        $actualReceiptNote = $repository->getById($receiptNoteId);

        $this->assertSameReceiptNote($expectedReceiptNote, $actualReceiptNote);
    }

    public function testItGeneratesTheNextIdentity() {
        $eventDispatcher = new EventDispatcher();
        $repository = new InMemoryReceiptNoteRepository($eventDispatcher);
        $this->assertNotEmpty($repository->nextIdentity());
    }

    private function assertSameReceiptNote(ReceiptNote $expectedReceiptNote, ReceiptNote $actualReceiptNote)
    {
        $this->assertEquals((string) $expectedReceiptNote->id(), (string) $actualReceiptNote->id());
        $this->assertEquals((string) $expectedReceiptNote->purchaseOrderId(), (string) $actualReceiptNote->purchaseOrderId());

        // TODO: Assert lines are the same
    }


}
