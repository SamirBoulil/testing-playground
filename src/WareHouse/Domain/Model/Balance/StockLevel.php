<?php

declare(strict_types=1);

namespace Warehouse\Domain\Model\Balance;

use Webmozart\Assert\Assert;

class StockLevel
{
    /** @var int */
    private $stockLevel;

    private function __construct()
    {}

    public static function fromInteger(int $stockLevel): self
    {
        Assert::greaterThanEq($stockLevel, 0);

        $newStock = new self();
        $newStock->stockLevel = $stockLevel;

        return $newStock;
    }

    public function asInteger(): int
    {
        return $this->stockLevel;
    }

    public function increase(int $quantity): self
    {
        $newStock = new self();
        $newStock->stockLevel = $this->stockLevel + $quantity;

        return $newStock;
    }
}
