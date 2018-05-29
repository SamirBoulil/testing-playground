<?php

declare(strict_types=1);

namespace WareHouse\Application\Subscribers;

use Warehouse\Domain\Model\ReceiptNote\LineAddedToReceiptNote;
use Warehouse\Domain\Repository\PurchaseOrderRepository;
use Warehouse\Domain\Repository\ReceiptNoteRepository;

class ProcessReceipt
{
    /** @var PurchaseOrderRepository */
    private $purchaseOrderRepository;

    /** @var ReceiptNoteRepository */
    private $receiptNoteRepository;

    public function __construct(
        PurchaseOrderRepository $purchaseOrderRepository,
        ReceiptNoteRepository $receiptNoteRepository
    ) {
        $this->purchaseOrderRepository = $purchaseOrderRepository;
        $this->receiptNoteRepository = $receiptNoteRepository;
    }

    public function __invoke(LineAddedToReceiptNote $event)
    {
        $receiptNote = $this->receiptNoteRepository->getById($event->receiptNoteId);
        $purchaseOrder = $this->purchaseOrderRepository->getById($receiptNote->purchaseOrderId());

        $purchaseOrder->processDelivery($event->productId, $event->quantityReceived);

        $this->purchaseOrderRepository->save($purchaseOrder);
    }
}
