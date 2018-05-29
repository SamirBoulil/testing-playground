<?php
declare(strict_types=1);

namespace WareHouse\Domain\Model\Balance;

use PHPUnit\Framework\TestCase;
use Warehouse\Domain\Model\Balance\StockLevel;

class StockLevelTest extends TestCase
{
    public function testBalanceCreation()
    {
        $stockLevel = StockLevel::fromInteger(12);

        $this->assertInstanceOf(StockLevel::class, $stockLevel);
        $this->assertSame(12, $stockLevel->asInteger());
    }

    public function testCanOnlyBePositive()
    {
        $this->expectException(\Exception::class);
        StockLevel::fromInteger(-1);
    }
}
