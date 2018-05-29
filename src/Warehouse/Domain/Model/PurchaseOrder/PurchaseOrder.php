<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use Warehouse\Domain\Model\Supplier\SupplierId;
use Webmozart\Assert\Assert;

class PurchaseOrder
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
}
