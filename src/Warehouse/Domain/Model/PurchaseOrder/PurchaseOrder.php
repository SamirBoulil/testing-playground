<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use Common\Aggregate;
use Common\AggregateId;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\Supplier\SupplierId;
use Webmozart\Assert\Assert;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived as ReceiptNoteQuantityReceived;

class PurchaseOrder extends Aggregate
{
    /** @var PurchaseOrderId */
    private $id;

    /** @var Line[] */
    private $lines;

    /** @var SupplierId */
    private $supplierId;

    public static function place(PurchaseOrderId $id, SupplierId $supplierId, array $lines): self
    {
        Assert::notEmpty($lines);
        self::assertLineNumbersUnique($lines);
        self::assertLinesHaveDifferentProducts($lines);


        $newPurchase = new static();
        $newPurchase->id = $id;
        $newPurchase->supplierId = $supplierId;
        $newPurchase->lines = $lines;

        return $newPurchase;
    }

    /**
     * @param Line[] $lines
     */
    private static function assertLineNumbersUnique(array $lines): void
    {
        $lineNumbers = [];
        foreach ($lines as $line) {
            $lineNumber = $line->getNumber();
            if (!in_array($lineNumber, $lineNumbers)) {
                $lineNumbers[] = $lineNumber;
            } else {
                throw new \InvalidArgumentException(
                    sprintf('Line with number %d, found two times in the lines.', $lineNumber)
                );
            }
        }
    }

    /**
     * @param Line[] $lines
     */
    private static function assertLinesHaveDifferentProducts($lines)
    {
        $productIds = [];
        foreach ($lines as $line) {
            $productId = (string) $line->getProductId();
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
        return $this->id;
    }

    public function quantityReceived(ProductId $productId): QuantityReceived
    {
        return $this->getLine($productId)->quantityReceived();
    }

    /**
     * @param $productId
     * @param $quantityReceived
     *
     */
    public function processDelivery(ProductId $productId, ReceiptNoteQuantityReceived $quantityReceived)
    {
        $line = $this->getLine($productId);
        $line->increaseReceivedQuantity($quantityReceived);
    }

    /**
     * @param ProductId $productId
     *
     * @return QuantityReceived
     *
     */
    private function getLine(ProductId $productId): Line
    {
        foreach ($this->lines as $line) {
            if ((string) $line->getProductId() === (string) $productId) {
                return $line;
            }
        }

        throw new \LogicException(sprintf('There is no lines for product "%s", ', (string) $productId));
    }
}
