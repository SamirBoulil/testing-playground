<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class ReceiptNoteIdTest extends TestCase
{
    public function testReceiptNoteIdCreation()
    {
        $this->assertInstanceOf(ReceiptNoteId::class, ReceiptNoteId::fromString(Uuid::uuid4()->toString()));
    }

    public function testItDoesNotCreateFromInteger()
    {
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(ReceiptNoteId::class, ReceiptNoteId::fromString(1));
    }

    public function testItDoesNotCreateFromEmptyString()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->assertInstanceOf(ReceiptNoteId::class, ReceiptNoteId::fromString(''));
    }
}
