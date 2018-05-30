<?php

declare(strict_types=1);

namespace WareHouse\Application\ReceiveReceiptNote;

use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteLine;
use Warehouse\Domain\Repository\ReceiptNoteRepository;

/**
 */
class ReceiveReceiptNoteHandler
{
    /** @var ReceiptNoteRepository */
    private $repository;

    public function __construct(ReceiptNoteRepository $repository)
    {
        $this->repository = $repository;
    }

    public function receive(ReceiveReceiptNote $receiveReceiptNote): void
    {
        $lines = $this->createLines($receiveReceiptNote);
        $receiptNote = ReceiptNote::create(
            $this->repository->nextIdentity(),
            $receiveReceiptNote->purchaseOrderId,
            $lines
        );
        $this->repository->save($receiptNote);
    }

    /**
     * @param ReceiveReceiptNote $receiveReceiptNote
     *
     * @return array
     */
    private function createLines(ReceiveReceiptNote $receiveReceiptNote): array
    {
        $lines = [];
        foreach ($receiveReceiptNote->lines as $line) {
            $lines[] = ReceiptNoteLine::create(
                ProductId::fromString($line[ReceiveReceiptNote::PRODUCT_ID]),
                QuantityReceived::fromInteger((int) $line[ReceiveReceiptNote::QUANTITY_RECEIVED])
            );
        }

        return $lines;
    }
}
