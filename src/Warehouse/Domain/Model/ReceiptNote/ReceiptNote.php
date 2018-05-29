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

        return $newReceiptNote;
    }

    private static function assertLinesHaveDifferentProducts(array $lines)
    {
        $productIds = [];
        foreach ($lines as $line) {
            $productId = $line->getProductId();
            if (!in_array($productId, $productIds)) {
                $productIds[] = $productId;
            } else {
                throw new \InvalidArgumentException(
                    sprintf('Line with productId %s, found two times in the lines.', (string) $productId)
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
