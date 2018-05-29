<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrder;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;

interface PurchaseOrderRepository
{
    public function save(PurchaseOrder $aggregate): void;

    public function getById(PurchaseOrderId $purchaseOrderId): PurchaseOrder;

    public function nextIdentity(): PurchaseOrderId;
}
