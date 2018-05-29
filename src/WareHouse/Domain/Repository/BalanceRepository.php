<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Warehouse\Domain\Model\Balance\Balance;
use Warehouse\Domain\Model\Product\ProductId;

interface BalanceRepository
{
    public function save(Balance $aggregate): void;

    public function getById(ProductId $productId): Balance;

    public function nextIdentity(): ProductId;
}
