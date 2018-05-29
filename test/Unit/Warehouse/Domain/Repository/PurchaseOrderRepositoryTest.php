<?php
declare(strict_types=1);

namespace WareHouse\Domain\Repository;

use Common\EventDispatcher\EventDispatcher;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\PurchaseOrder\Line;
use Warehouse\Domain\Model\PurchaseOrder\LineNumber;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrder;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;
use Warehouse\Domain\Model\PurchaseOrder\QuantityOrdered;
use Warehouse\Domain\Model\PurchaseOrder\QuantityReceived;
use Warehouse\Domain\Model\Supplier\SupplierId;

class PurchaseOrderRepositoryTest extends TestCase
{

    public function testSavesAndReturnsAPurchaseOrder()
    {
        $eventDispatcher = new EventDispatcher();
        $repository = new InMemoryPurchaseOrderRepository($eventDispatcher);
        $PurchaseOrderId = PurchaseOrderId::fromString(Uuid::uuid4()->toString());
        $expectedPurchaseOrder = PurchaseOrder::place(
            $PurchaseOrderId,
            SupplierId::fromString(Uuid::uuid4()->toString()),
            [
                Line::create(
                    LineNumber::fromInteger(1),
                    QuantityOrdered::fromInteger(1),
                    QuantityReceived::fromInteger(1),
                    ProductId::fromString(Uuid::uuid4()->toString())
                ),
            ]
        );

        $repository->save($expectedPurchaseOrder);
        $actualPurchaseOrder = $repository->getById($PurchaseOrderId);

        $this->assertSamePurchaseOrder($expectedPurchaseOrder, $actualPurchaseOrder);
    }

    public function testItGeneratesTheNextIdentity()
    {
        $eventDispatcher = new EventDispatcher();
        $repository = new InMemoryPurchaseOrderRepository($eventDispatcher);
        $this->assertNotEmpty($repository->nextIdentity());
    }

    private function assertSamePurchaseOrder(PurchaseOrder $expectedPurchaseOrder, PurchaseOrder $actualPurchaseOrder)
    {
        $this->assertEquals((string) $expectedPurchaseOrder->id(), (string) $actualPurchaseOrder->id());
        // TODO: Assert lines are the same
    }
}
