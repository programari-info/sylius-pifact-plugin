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

use Doctrine\ORM\Mapping as ORM;

trait PifactAddressTrait
{
    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    protected ?string $pifactTaxId;

    public function getPifactTaxId(): ?string
    {
        return $this->pifactTaxId;
    }

    public function setPifactTaxId(?string $pifactTaxId): void
    {
        $this->pifactTaxId = $pifactTaxId;
    }
}
