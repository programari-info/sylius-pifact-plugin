<?php

declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\Form\Extension;

use Sylius\Bundle\AddressingBundle\Form\Type\AddressType;
use Sylius\Component\Core\Model\ChannelInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddressTypeExtension extends AbstractTypeExtension
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('pifactTaxId', TextType::class, [
            'label' => 'pifact.form.address.pifact_tax_id',
            'required' => false,
            'help' => 'pifact.form.address.pifact_tax_id_hint'
        ]);
    }

    public static function getExtendedTypes(): array
    {
        return [AddressType::class];
    }
}
