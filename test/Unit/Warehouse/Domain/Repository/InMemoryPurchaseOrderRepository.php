<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Common\AggregateNotFound;
use Common\AggregateRepository;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrder;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;


class InMemoryPurchaseOrderRepository extends AggregateRepository implements PurchaseOrderRepository
{
    public function save(PurchaseOrder $aggregate): void
    {
        $this->store($aggregate);
    }

    public function getById(PurchaseOrderId $purchaseOrderId): PurchaseOrder
    {
        $aggregate = $this->load((string)$purchaseOrderId);

        if (!$aggregate instanceof PurchaseOrder) {
            throw AggregateNotFound::with(PurchaseOrder::class, (string)$purchaseOrderId);
        }

        return $aggregate;
    }

    public function nextIdentity(): PurchaseOrderId
    {
        return PurchaseOrderId::fromString($this->generateUuid());
    }
}
