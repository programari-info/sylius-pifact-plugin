<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\Creator;

use Programari\SyliusPifactPlugin\Entity\PifactInvoice;
use Programari\SyliusPifactPlugin\Services\Api;
use Doctrine\ORM\Exception\ORMException;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\InvoicingPlugin\Creator\InvoiceCreatorInterface;
use Sylius\InvoicingPlugin\Doctrine\ORM\InvoiceRepositoryInterface;
use Sylius\InvoicingPlugin\Entity\Invoice;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Sylius\InvoicingPlugin\Exception\InvoiceAlreadyGenerated;
use Sylius\InvoicingPlugin\Generator\InvoiceGeneratorInterface;
use Sylius\InvoicingPlugin\Generator\InvoicePdfFileGeneratorInterface;
use Sylius\InvoicingPlugin\Manager\InvoiceFileManagerInterface;

final class InvoiceCreator implements InvoiceCreatorInterface
{
    public function __construct(
        private readonly InvoiceRepositoryInterface $invoiceRepository,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly InvoiceGeneratorInterface $invoiceGenerator,
        private readonly InvoicePdfFileGeneratorInterface $invoicePdfFileGenerator,
        private readonly InvoiceFileManagerInterface $invoiceFileManager,
        private readonly bool $hasEnabledPdfFileGenerator = false,
        private readonly Api $api
    ) {
    }

    public function __invoke(string $orderNumber, \DateTimeInterface $dateTime): void
    {
        /** @var OrderInterface $order */
        $order = $this->orderRepository->findOneByNumber($orderNumber);

        /** @var InvoiceInterface|null $invoice */
        $invoice = $this->invoiceRepository->findOneByOrder($order);

        if (null !== $invoice) {
            throw InvoiceAlreadyGenerated::withOrderNumber($orderNumber);
        }
        /** @var Invoice $invoice */
        $invoice = $this->invoiceGenerator->generateForOrder($order, $dateTime);

        $pifactInvoice = $this->api->getPifactInvoice($invoice, $order);

        // Cridar a l'API per a crear la factura amb el json de $invoice
        // Call API to create invoice with json of $invoice
        $result = $this->api->sendInvoice($pifactInvoice);
        if ($result->getStatus() !== 'OK') {
            throw new \RuntimeException($result->getMessage());
        }
        $pifactInvoice->setNumber($result->getNumber());
        $pifactInvoice->setPdfUrl($result->getPdfUrl());

        $this->invoiceRepository->add($invoice);
        $this->invoiceRepository->add($pifactInvoice);
        // No necessito generar PDF ja que es fa a PiFact
        // No need to generate PDF because it's done by PiFact

//        if (!$this->hasEnabledPdfFileGenerator) {
//            $this->invoiceRepository->add($invoice);
//
//            return;
//        }
//
//        $invoicePdf = $this->invoicePdfFileGenerator->generate($invoice);
//        $this->invoiceFileManager->save($invoicePdf);
//
//        try {
//            $this->invoiceRepository->add($invoice);
//        } catch (ORMException) {
//            $this->invoiceFileManager->remove($invoicePdf);
//        }
    }

}
