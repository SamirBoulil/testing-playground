<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Common\AggregateNotFound;
use Common\AggregateRepository;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteId;


class InMemoryReceiptNoteRepository extends AggregateRepository implements ReceiptNoteRepository
{
    public function save(ReceiptNote $aggregate): void
    {
        $this->store($aggregate);
    }

    public function getById(ReceiptNoteId $exampleAggregateId): ReceiptNote
    {
        $aggregate = $this->load((string)$exampleAggregateId);

        if (!$aggregate instanceof ReceiptNote) {
            throw AggregateNotFound::with(ReceiptNote::class, (string)$exampleAggregateId);
        }

        return $aggregate;
    }

    public function nextIdentity(): ReceiptNoteId
    {
        return ReceiptNoteId::fromString($this->generateUuid());
    }
}
