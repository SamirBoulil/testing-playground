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

require __DIR__ . '/../bootstrap.php';

$eventDispatcher = new EventDispatcher();
$eventDispatcher->subscribeToAllEvents(new EventCliLogger());
//$eventDispatcher->registerSubscriber(ExampleAggregateCreated::class, new ExampleAggregateCreatedSubscriber());
//
//$exampleAggregateRepository = new ExampleAggregateRepository($eventDispatcher);

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

//$exampleAggregateRepository->save($aggregate);
