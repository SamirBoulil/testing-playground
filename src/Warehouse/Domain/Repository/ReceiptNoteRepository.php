<?php
declare(strict_types=1);

namespace Warehouse\Domain\Repository;

use Warehouse\Domain\Model\ReceiptNote\ReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteId;

interface ReceiptNoteRepository
{
    public function save(ReceiptNote $aggregate): void;

    public function getById(ReceiptNoteId $exampleAggregateId): ReceiptNote;

    public function nextIdentity(): ReceiptNoteId;
}
