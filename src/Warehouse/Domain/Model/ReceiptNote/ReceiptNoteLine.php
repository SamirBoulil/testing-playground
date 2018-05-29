<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use Warehouse\Domain\Model\Product\ProductId;

class ReceiptNoteLine
{
    /** @var ProductId */
    private $productId;

    /** @var QuantityReceived */
    private $quantityReceived;

    private function __construct()
    {}

    public static function create(ProductId $productId, QuantityReceived $quantityReceived): self
    {
        $newReceiptNoteLine = new self();
        $newReceiptNoteLine->productId = $productId;
        $newReceiptNoteLine->quantityReceived = $quantityReceived;

        return $newReceiptNoteLine;
    }

    public function getProductId(): string
    {
        return (string) $this->productId;
    }
}
