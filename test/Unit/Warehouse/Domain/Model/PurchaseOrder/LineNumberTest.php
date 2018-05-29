<?php
declare(strict_types=1);

namespace Warehouse\Domain\Model\PurchaseOrder;

use PHPUnit\Framework\TestCase;

/**
 * TODO
 *
 * @author    Christophe Chausseray <christophe.chausseray@akeneo.com>
 * @copyright 2018 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LineNumberTest extends TestCase
{
    public function testLineNumberCreation()
    {
        $this->assertInstanceOf(LineNumber::class, LineNumber::fromInteger(1));
    }

    public function testItDoesNotCreateFromString()
    {
        $this->expectException(\TypeError::class);
        $this->assertInstanceOf(LineNumber::class, LineNumber::fromInteger('test'));
    }
}
