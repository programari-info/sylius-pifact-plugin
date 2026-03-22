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

namespace Programari\SyliusPifactPlugin\Repository;


use Programari\SyliusPifactPlugin\Entity\PifactInvoiceInterface;
use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;
use Webmozart\Assert\Assert;

class PifactInvoiceRepository extends EntityRepository implements PifactInvoiceRepositoryInterface
{
    public function findOneByInvoice(InvoiceInterface $invoice): ?PifactInvoiceInterface
    {
        /** @var PifactInvoiceInterface|null $invoice */
        $invoice = $this->findOneBy(['invoice' => $invoice]);

        return $invoice;
    }

}
