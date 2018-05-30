<?php

declare(strict_types=1);

namespace Warehouse\Domain\Model\Balance;

use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived;

/**
 * {description}
 *
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @copyright 2018 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Balance
{
    /** @var array */
    private $productId;

    /** @var StockLevel */
    private $stockLevel;

    public function __construct(ProductId $productId, StockLevel $stockLevel)
    {
        $this->productId = $productId;
        $this->stockLevel = $stockLevel;
    }

    public function processDelivery(QuantityReceived $quantity)
    {
        $this->stockLevel = $this->stockLevel->increase($quantity->asInteger());
    }

    public function stockLevel()
    {
        return $this->stockLevel;
    }

    public function productId()
    {
        return $this->productId;
    }
}
