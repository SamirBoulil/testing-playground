<?php
declare(strict_types=1);

namespace Example;

use Common\EventDispatcher\EventCliLogger;
use Common\EventDispatcher\EventDispatcher;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteId;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteLine;
use Warehouse\Domain\Repository\InMemoryReceiptNoteRepository;

require __DIR__ . '/../bootstrap.php';

$eventDispatcher = new EventDispatcher();
$eventDispatcher->subscribeToAllEvents(new EventCliLogger());

$repository = new InMemoryReceiptNoteRepository($eventDispatcher);
$aggregate = ReceiptNote::create(
    ReceiptNoteId::fromString(Uuid::uuid4()->toString()), 
    PurchaseOrderId::fromString(Uuid::uuid4()->toString()), 
    [
        ReceiptNoteLine::create(
            ProductId::fromString(Uuid::uuid4()->toString()),
            QuantityReceived::fromInteger(1)
        )
    ]
);

$repository->save($aggregate);
