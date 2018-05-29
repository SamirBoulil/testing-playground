<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use Common\Aggregate;
use Common\AggregateId;
use DateTimeImmutable;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;
use Webmozart\Assert\Assert;

class ReceiptNote extends Aggregate
{
    /** @var ReceiptNoteId */
    private $receiptNoteId;

    /** @var PurchaseOrderId */
    private $purchaseOrderId;

    /** @var ReceiptNoteLine[] */
    private $lines;

    private function __construct()
    {
    }

    /**
     * @param ReceiptNoteId     $receiptNoteId
     * @param PurchaseOrderId   $purchaseOrderId
     * @param ReceiptNoteLine[] $lines
     *
     * @return ReceiptNote
     *
     * @throws \Exception
     */
    public static function create(ReceiptNoteId $receiptNoteId, PurchaseOrderId $purchaseOrderId, array $lines): self
    {
        Assert::notEmpty($lines);
        self::assertLinesHaveDifferentProducts($lines);

        $newReceiptNote = new self();
        $newReceiptNote->receiptNoteId = $receiptNoteId;
        $newReceiptNote->purchaseOrderId = $purchaseOrderId;
        $newReceiptNote->lines = $lines;

        $newReceiptNote->recordThat(
            new ReceiptNoteCreated($newReceiptNote->receiptNoteId, new DateTimeImmutable())
        );
        foreach ($newReceiptNote->lines as $line) {
            $newReceiptNote->recordThat(
                new LineAddedToReceiptNote(
                    $newReceiptNote->receiptNoteId,
                    $line->productId(),
                    $line->quantityReceived(),
                    new DateTimeImmutable()
                )
            );
        }

        return $newReceiptNote;
    }

    private static function assertLinesHaveDifferentProducts(array $lines)
    {
        $productIds = [];
        foreach ($lines as $line) {
            $productId = (string) $line->productId();
            if (!in_array($productId, $productIds)) {
                $productIds[] = $productId;
            } else {
                throw new \InvalidArgumentException(
                    sprintf('Line with productId %s, found two times in the lines.', $productId)
                );
            }
        }
    }

    public function id(): AggregateId
    {
        return $this->receiptNoteId;
    }

    public function purchaseOrderId(): PurchaseOrderId
    {
        return $this->purchaseOrderId;
    }
}
