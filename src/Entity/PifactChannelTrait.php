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

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait PifactChannelTrait
{
    #[ORM\Column(type: Types::STRING, length: 100, nullable: true)]
    private ?string $bearer;

    /**
     * @return mixed
     */
    public function getBearer(): ?string
    {
        return $this->bearer;
    }

    /**
     * @param mixed $bearer
     */
    public function setBearer(?string $bearer): void
    {
        $this->bearer = $bearer;
    }
}
