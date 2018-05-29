<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use Webmozart\Assert\Assert;

class QuantityOrdered
{
    /** @var int */
    private $quantity;

    private function __construct() {}

    public static function fromInteger(int $quantity): QuantityOrdered
    {
        Assert::greaterThan($quantity, 0);

        $newQuantity = new static($quantity);
        $newQuantity->quantity = $quantity;

        return $newQuantity;
    }
}
