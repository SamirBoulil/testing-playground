<?php

declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived as ReceiptNoteQuantityReceived;

class Line
{
    /** @var QuantityReceived */
    private $quantityReceived;

    /** @var LineNumber */
    private $lineNumber;

    /** @var QuantityOrdered */
    private $quantityOrdered;

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
        $newLine->quantityReceived = $quantityReceived;
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

    public function quantityReceived(): QuantityReceived
    {
        return $this->quantityReceived;
    }

    public function increaseReceivedQuantity(ReceiptNoteQuantityReceived $increase): void
    {
        $this->quantityReceived = QuantityReceived::fromInteger(
            $this->quantityReceived()->asInteger() + $increase->asInteger()
        );
    }
}
