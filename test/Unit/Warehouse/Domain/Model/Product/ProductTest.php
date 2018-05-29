<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Product;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ProductTest extends TestCase
{
    public function testProductCreation()
    {
        $product = ProductId::fromString(Uuid::uuid4()->toString());
        $name =  Name::fromString('test');

        $this->assertInstanceOf(Product::class, Product::create($product, $name));
    }
}
