<?php

declare(strict_types=1);

namespace WareHouse\Application\Subscribers;
use Warehouse\Domain\Model\ReceiptNote\LineAddedToReceiptNote;
use Warehouse\Domain\Repository\BalanceRepository;

class UpdateBalance
{
    /** @var BalanceRepository  */
    private $balanceRepository;

    public function __construct(BalanceRepository $balanceRepository)
    {
        $this->balanceRepository = $balanceRepository;
    }

    public function __invoke(LineAddedToReceiptNote $event)
    {
        $balance = $this->balanceRepository->getById($event->productId);

        $balance->processDelivery($event->quantityReceived);

        $this->balanceRepository->save($balance);
    }
}
