<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\Supplier;


class Supplier
{
    /** @var SupplierId */
    private $id;

    /** @var Name */
    private $name;

    private function __construct()
    {
    }

    public static function create(SupplierId $supplierId, Name $name): self
    {
        $newSupplier = new self();
        $newSupplier->id = $supplierId;
        $newSupplier->name = $name;

        return $newSupplier;
    }
}
