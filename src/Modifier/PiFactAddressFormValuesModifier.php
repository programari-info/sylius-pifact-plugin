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

namespace Programari\SyliusPifactPlugin\Modifier;

use Sylius\Bundle\ShopBundle\Modifier\AddressFormValuesModifierInterface;
use Sylius\Component\Addressing\Model\AddressInterface;

final readonly class PiFactAddressFormValuesModifier implements AddressFormValuesModifierInterface
{
    /**
     * @param array<string, mixed> $addressData
     *
     * @return array<string, mixed>
     */
    public function modify(array $addressData, AddressInterface $address): array
    {
        $addressData['firstName'] = $address->getFirstName();
        $addressData['lastName'] = $address->getLastName();
        $addressData['phoneNumber'] = $address->getPhoneNumber();
        $addressData['company'] = $address->getCompany();
        $addressData['countryCode'] = $address->getCountryCode();
        if ($address->getProvinceCode() !== null) {
            $addressData['provinceCode'] = $address->getProvinceCode();
        }
        if ($address->getProvinceName() !== null) {
            $addressData['provinceName'] = $address->getProvinceName();
        }
        $addressData['street'] = $address->getStreet();
        $addressData['city'] = $address->getCity();
        $addressData['postcode'] = $address->getPostcode();
        $addressData['pifactTaxId'] = $address->getPifactTaxId();

        return $addressData;
    }
}
