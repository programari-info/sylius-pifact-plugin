<?php


/*
 * This file is part of the PiFact package.
 *
 * (c) Programari Enginyeria Informàtica SL
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */


declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\Entity;

use App\Entity\Channel\Channel;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Sylius\Bundle\MoneyBundle\Formatter\MoneyFormatter;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\InvoicingPlugin\Entity\Invoice;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'pifact_plugin_invoice')]
class PifactInvoice implements PifactInvoiceInterface
{

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: Types::BIGINT)]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    protected Invoice $invoice;

    #[ORM\Column(type: Types::STRING, length: 255)]
    protected string $pdfUrl;

    #[ORM\Column(type: Types::STRING, length: 20, nullable: true)]
    protected ?string $customerTaxId='';

    #[ORM\Column(type: Types::STRING, length: 20, nullable: true)]
    protected ?string $number='';

    #[ORM\Column(type: Types::STRING, length: 255)]
    protected ?string $email;
    #[ORM\Column(type: Types::INTEGER)]
    protected int $moneyBase;

    #[ORM\Column(type: Types::STRING, length: 255, nullable: true)]
    protected ?string $paymentMethod='';

    // Temporary fields to use at API and serialize
    protected bool $apiTest = false; // Used to test api
    protected ?string $orderNumber;

    private int $customerId;

    public function setNumber(string $number)
    {
        $this->number = $number;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function getIssuedAt(): \DateTimeInterface
    {
        return $this->invoice->issuedAt();
    }

    public function getBillingData()
    {
        return $this->invoice->billingData();
    }

    public function getCurrencyCode(): string
    {
        return $this->invoice->currencyCode();
    }

    public function getLocaleCode(): string
    {
        return $this->invoice->localeCode();
    }

    public function getTotal(): int
    {
        return $this->invoice->total();
    }

    public function getLineItems(): Collection
    {
        return $this->invoice->lineItems();
    }

    public function getTaxItems(): Collection
    {
        return $this->invoice->taxItems();
    }

    public function getPaymentState(): string
    {
        return $this->invoice->paymentState();
    }

    public function getShopBillingData()
    {
        return $this->invoice->shopBillingData();
    }

    public function getChannel(): ChannelInterface
    {
        return $this->invoice->channel();
    }



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMoneyBase(): int
    {
        return $this->moneyBase;
    }

    public function setMoneyBase(int $moneyBase): void
    {
        $this->moneyBase = $moneyBase;
    }

    public function getOrderNumber(): ?string
    {
        return $this->orderNumber;
    }

    public function setOrderNumber(?string $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    public function isApiTest(): bool
    {
        return $this->apiTest;
    }

    public function setApiTest(bool $apiTest): void
    {
        $this->apiTest = $apiTest;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getPdfUrl(): string
    {
        return $this->pdfUrl;
    }

    public function setPdfUrl(string $pdfUrl): void
    {
        $this->pdfUrl = $pdfUrl;
    }

    public function getCustomerTaxId(): ?string
    {
        return $this->customerTaxId;
    }

    public function setCustomerTaxId(?string $customerTaxId): void
    {
        $this->customerTaxId = $customerTaxId;
    }

    public function getInvoice(): Invoice
    {
        return $this->invoice;
    }

    public function setInvoice(Invoice $invoice): void
    {
        $this->invoice = $invoice;
    }

    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    public function getPaymentMethod(): ?string
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): void
    {
        $this->paymentMethod = $paymentMethod;
    }

}
