<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Supplier;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class SupplierTest extends TestCase
{
    public function testSupplierCreation()
    {
        $product = SupplierId::fromString(Uuid::uuid4()->toString());
        $name =  Name::fromString('test');

        $this->assertInstanceOf(Supplier::class, Supplier::create($product, $name));
    }
}
