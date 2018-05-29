<?php

declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use Warehouse\Domain\Model\Product\ProductId;

class Line
{
    /** @var LineNumber */
    private $lineNumber;

    /** @var QuantityOrdered */
    private $quantityOrdered;

    /** @var QuantityReceived */
    private $quandtityReceived;

    /** @var ProductId */
    private $productId;

    private function __construct()
    {
    }

    public static function create(
        LineNumber $lineNumber,
        QuantityOrdered $quantityOrdered,
        QuantityReceived $quantityReceived,
        ProductId $productId
    ) {
        $newLine = new static();
        $newLine->lineNumber = $lineNumber;
        $newLine->quantityOrdered = $quantityOrdered;
        $newLine->quandtityReceived = $quantityReceived;
        $newLine->productId = $productId;

        return $newLine;
    }

    public function getNumber(): int
    {
        return $this->lineNumber->toInteger();
    }

    public function getProductId(): ProductId
    {
        return $this->productId;
    }
}
