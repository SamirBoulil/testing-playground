<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Product;

class Product
{
    /** @var ProductId */
    private $id;

    /** @var Name */
    private $name;

    private function __construct(){}

    public static function create(ProductId $id, Name $name): Product
    {
        return new static($id, $name);
    }
}
