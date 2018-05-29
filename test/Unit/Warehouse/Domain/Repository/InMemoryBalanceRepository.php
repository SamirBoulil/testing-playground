<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Common\AggregateNotFound;
use Common\AggregateRepository;
use Warehouse\Domain\Model\Balance\Balance;
use Warehouse\Domain\Model\Product\ProductId;

class InMemoryBalanceRepository extends AggregateRepository implements BalanceRepository
{
    public function save(Balance $aggregate): void
    {
        $this->store($aggregate);
    }

    public function getById(ProductId $productId): Balance
    {
        $aggregate = $this->load((string) $productId);

        if (!$aggregate instanceof Balance) {
            throw AggregateNotFound::with(ProductId::class, (string) $productId);
        }

        return $aggregate;
    }

    public function nextIdentity(): ProductId
    {
        throw new \Exception('Cannot create the next identity.');
    }
}
