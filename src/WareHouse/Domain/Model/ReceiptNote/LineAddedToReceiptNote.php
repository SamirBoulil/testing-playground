<?php

declare(strict_types=1);

namespace Warehouse\Domain\Model\ReceiptNote;

use DateTimeImmutable;
use Warehouse\Domain\Model\Product\ProductId;

/**
 * {description}
 *
 * @author    Samir Boulil <samir.boulil@akeneo.com>
 * @copyright 2018 Akeneo SAS (http://www.akeneo.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class LineAddedToReceiptNote
{
    /** @var ReceiptNoteId */
    public $receiptNoteId;

    /** @var ProductId */
    public $productId;

    /** @var QuantityReceived */
    public $quantityReceived;

    /** @var DateTimeImmutable */
    public $dateTimeImmutable;

    /**
     * LineAddedToReceiptNote constructor.
     *
     * @param ReceiptNoteId     $receiptNoteId
     * @param ProductId         $productId
     * @param QuantityReceived  $quantityReceived
     * @param DateTimeImmutable $dateTimeImmutable
     */
    public function __construct(
        ReceiptNoteId $receiptNoteId,
        ProductId $productId,
        QuantityReceived $quantityReceived,
        DateTimeImmutable $dateTimeImmutable
    ) {
        $this->receiptNoteId = $receiptNoteId;
        $this->productId = $productId;
        $this->quantityReceived = $quantityReceived;
        $this->dateTimeImmutable = $dateTimeImmutable;
    }
}
