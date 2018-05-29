<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use DateTimeImmutable;

final class ReceiptNoteCreated
{
    private $createdAt;

    private $receiptNoteId;

    public function __construct(ReceiptNoteId $receiptNoteId, DateTimeImmutable $createdAt)
    {
        $this->receiptNoteId = $receiptNoteId;
        $this->createdAt = $createdAt;
    }

    public function receiptNoteId(): ReceiptNoteId
    {
        return $this->receiptNoteId;
    }

    public function createdAt(): DateTimeImmutable
    {
        return $this->createdAt;
    }
}
