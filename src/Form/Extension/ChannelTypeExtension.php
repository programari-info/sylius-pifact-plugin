<?php


declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\Form\Extension;


use Sylius\Bundle\ChannelBundle\Form\Type\ChannelType as BaseChannelType;
use Symfony\Component\Form\AbstractTypeExtension;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

final class ChannelTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('bearer', TextType::class, [
                'label' => 'pifact.form.channel.bearer',
                'required' => false,
                'help' => 'pifact.form.channel.bearer_hint'
            ])

        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [BaseChannelType::class];
    }

}
