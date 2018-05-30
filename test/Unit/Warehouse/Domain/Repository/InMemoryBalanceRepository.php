<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Common\AggregateNotFound;
use Common\AggregateRepository;
use Common\EventDispatcher\EventDispatcher;
use Warehouse\Domain\Model\Balance\Balance;
use Warehouse\Domain\Model\Balance\StockLevel;
use Warehouse\Domain\Model\Product\ProductId;

class InMemoryBalanceRepository implements BalanceRepository
{
    /** @var Balance[] */
    private $objects;

    public function save(Balance $balance): void
    {
        $this->objects[(string)$balance->productId()] = $balance;
    }

    public function getById(ProductId $productId): Balance
    {
        if (!isset($this->objects[(string) $productId])) {
            return new Balance($productId, StockLevel::fromInteger(0));
        }

        return $this->objects[(string) $productId];
    }
}
