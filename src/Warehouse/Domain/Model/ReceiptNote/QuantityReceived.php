<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use Webmozart\Assert\Assert;

class QuantityReceived
{
    /** @var int */
    private $quantity;

    private function __construct() {}

    public static function fromInteger(int $quantity): QuantityReceived
    {
        Assert::greaterThanEq($quantity, 0);

        $newQuantity = new static($quantity);
        $newQuantity->quantity = $quantity;

        return $newQuantity;
    }
}
