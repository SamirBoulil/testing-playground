<?php
declare(strict_types=1);

namespace Test\Acceptance;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Common\EventDispatcher\EventDispatcher;
use PHPUnit\Framework\Assert;
use WareHouse\Application\ReceiveReceiptNote\ReceiveReceiptNote;
use WareHouse\Application\ReceiveReceiptNote\ReceiveReceiptNoteHandler;
use WareHouse\Application\Subscribers\ProcessReceipt;
use WareHouse\Application\Subscribers\UpdateBalance;
use Warehouse\Domain\Model\Product\ProductId;
use Warehouse\Domain\Model\PurchaseOrder\Line;
use Warehouse\Domain\Model\PurchaseOrder\LineNumber;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrder;
use Warehouse\Domain\Model\PurchaseOrder\PurchaseOrderId;
use Warehouse\Domain\Model\PurchaseOrder\QuantityOrdered;
use Warehouse\Domain\Model\PurchaseOrder\QuantityReceived as PurchaseOrderQuantityReceived;
use Warehouse\Domain\Model\ReceiptNote\LineAddedToReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\QuantityReceived;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNote;
use Warehouse\Domain\Model\ReceiptNote\ReceiptNoteLine;
use Warehouse\Domain\Model\Supplier\SupplierId;
use Warehouse\Domain\Repository\BalanceRepository;
use Warehouse\Domain\Repository\InMemoryBalanceRepository;
use Warehouse\Domain\Repository\InMemoryPurchaseOrderRepository;
use Warehouse\Domain\Repository\InMemoryReceiptNoteRepository;
use Warehouse\Domain\Repository\PurchaseOrderRepository;
use Warehouse\Domain\Repository\ReceiptNoteRepository;

final class FeatureContext implements Context
{
    /** @var ReceiveReceiptNoteHandler */
    private $receiveReceiptNoteHandler;

    /** @var PurchaseOrderId */
    private $purchaseOrderId;

    /** @var PurchaseOrderRepository */
    private $purchaseOrderRepository;

    /** @var ReceiptNoteRepository */
    private $receiptNoteRepository;

    /** @var BalanceRepository  */
    private $balanceRepository;

    public function __construct()
    {
        $this->purchaseOrderId = null;

        $eventDispatcher = new EventDispatcher();

        $this->purchaseOrderRepository = new InMemoryPurchaseOrderRepository($eventDispatcher);
        $this->receiptNoteRepository = new InMemoryReceiptNoteRepository($eventDispatcher);
        $this->balanceRepository = new InMemoryBalanceRepository();

        $eventDispatcher->registerSubscriber(
            LineAddedToReceiptNote::class,
            new ProcessReceipt(
                $this->purchaseOrderRepository,
                $this->receiptNoteRepository
            )
        );

        $eventDispatcher->registerSubscriber(
            LineAddedToReceiptNote::class,
            new UpdateBalance(
                $this->balanceRepository
            )
        );

        $this->receiveReceiptNoteHandler = new ReceiveReceiptNoteHandler(
            $this->receiptNoteRepository
        );
    }

    /**
     * @Given /^I am a pending step$/
     */
    public function iAmAPendingStep(): void
    {
        throw new PendingException();
    }

    /**
     * @Given /^the following products:$/
     */
    public function theFollowingProducts(TableNode $table)
    {
    }

    /**
     * @Given /^I place a purchase order for the supplier "([^"]*)" and the following lines:$/
     */
    public function iPlaceAPurchaseOrderForTheSupplierAndTheFollowingLines(string $supplierId, TableNode $table)
    {
        $lines = [];
        foreach ($table->getHash() as $i => $line) {
            $lines[] = Line::create(
                LineNumber::fromInteger($i),
                QuantityOrdered::fromInteger((int) $line['quantity_ordered']),
                PurchaseOrderQuantityReceived::fromInteger(0),
                ProductId::fromString($line['product_id'])
            );
        }

        $this->purchaseOrderId = $this->purchaseOrderRepository->nextIdentity();
        $purchaseOrder = PurchaseOrder::place(
            $this->purchaseOrderId,
            SupplierId::fromString($supplierId),
            $lines
        );
        $this->purchaseOrderRepository->save($purchaseOrder);
    }

    /**
     * @When /^I receive a receipt note for this purchase order with lines:$/
     */
    public function iReceiveAReceiptNoteForThisPurchaseOrderWithLines(TableNode $table)
    {
        $lines = [];
        foreach ($table->getHash() as $i => $line) {
            $lines[] = [
                ReceiveReceiptNote::PRODUCT_ID        => $line['product_id'],
                ReceiveReceiptNote::QUANTITY_RECEIVED => $line['quantity_received'],
            ];
        }

        $receiveReceiptNoteCommand = new ReceiveReceiptNote();
        $receiveReceiptNoteCommand->purchaseOrderId = $this->purchaseOrderId;
        $receiveReceiptNoteCommand->lines = $lines;

        $this->receiveReceiptNoteHandler->receive($receiveReceiptNoteCommand);
    }

    /**
     * @Then /^the quantity received for product "([^"]*)" should be (\d+)$/
     */
    public function theQuantityReceivedForProductShouldBe(string $productId, int $expectedQuantityReceived)
    {
        $purchaseOrder = $this->purchaseOrderRepository->getById($this->purchaseOrderId);
        Assert::assertEquals(
            $expectedQuantityReceived,
            $purchaseOrder->quantityReceived(ProductId::fromString($productId))->asInteger()
        );
    }

    /**
     * @Then /^the balance for product "([^"]*)" should be (\d+)$/
     */
    public function theBalanceForProductShouldBe(string $productId, int $expectedQuantityReceived)
    {
        $balance = $this->balanceRepository->getById(ProductId::fromString($productId));
        Assert::assertEquals(
            $expectedQuantityReceived,
            $balance->stockLevel()->asInteger()
        );
    }
}
