<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Product;

use Webmozart\Assert\Assert;


class Name
{
    /** @var string */
    private $name;

    private function __construct(){}

    public static function fromString(string $name): Name
    {
        Assert::notEmpty($name);

        $newName = new static();
        $newName->name = $name;

        return $newName;
    }
}
