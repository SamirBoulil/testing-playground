<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use Webmozart\Assert\Assert;

class LineNumber
{
    /** @var int */
    private $number;

    private function __construct() {}

    public static function fromInteger(int $number): LineNumber
    {
        $newLineNumber = new static($number);
        $newLineNumber->number = $number;

        return $newLineNumber;
    }

    public function toInteger(): int
    {
        return $this->number;
    }
}
