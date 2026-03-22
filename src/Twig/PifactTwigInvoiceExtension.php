<?php

/*
 * This file is part of the PiFact package.
 *
 * (c) Programari Enginyeria Informàtica SL
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Programari\SyliusPifactPlugin\Twig;

use Programari\SyliusPifactPlugin\Entity\PifactInvoice;
use Programari\SyliusPifactPlugin\Repository\PifactInvoiceRepositoryInterface;
use Twig\Attribute\AsTwigFunction;

// The class "Programari\SyliusPifactPlugin\Twig\PifactTwigInvoiceExtension" cannot extend "Twig\Extension\AbstractExtension"
// and use the "#[Twig\Attribute\AsTwigFunction]" attribute on method "getPdfUrl()", choose one or the other.
// Cal definir autoconfigure true i autowire true:
//         <service id="pifact.twig.extension.invoice"
//                 class="Programari\SyliusPifactPlugin\Twig\PifactTwigInvoiceExtension"
//                    public="true"
//                    autoconfigure="true"
//                autowire="true"
//            >
//        </service>
class PifactTwigInvoiceExtension //extends \Twig\Extension\AbstractExtension
{
    public function __construct(
        private PifactInvoiceRepositoryInterface $invoiceRepository,
    )
    {
    }

    #[AsTwigFunction('pifact_pdfurl')]
    public function getPdfUrl($invoice): string
    {
        /** @var PifactInvoice $pifactinvoice */
        $pifactinvoice = $this->invoiceRepository->findOneBy(['invoice' => $invoice]);
        return $pifactinvoice?->getPdfUrl()??'';
    }

    #[AsTwigFunction('pifact_number')]
    public function getNumber($invoice): string
    {
        /** @var PifactInvoice $pifactinvoice */
        $pifactinvoice = $this->invoiceRepository->findOneBy(['invoice' => $invoice]);
        return $pifactinvoice?->getNumber()??'';
    }
    #[AsTwigFunction('pifact_taxid')]
    public function getCustomerTaxId($invoice): string
    {
        /** @var PifactInvoice $pifactinvoice */
        $pifactinvoice = $this->invoiceRepository->findOneBy(['invoice' => $invoice]);
        return $pifactinvoice?->getCustomerTaxId()??'';
    }
}
