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
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Sylius\InvoicingPlugin\Entity\InvoiceInterface;

interface PifactInvoiceRepositoryInterface extends RepositoryInterface
{
    public function findOneByInvoice(InvoiceInterface $invoice): ?PifactInvoiceInterface;

}
