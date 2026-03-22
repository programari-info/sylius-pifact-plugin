<?php

declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\DependencyInjection;

use Sylius\Bundle\CoreBundle\DependencyInjection\PrependDoctrineMigrationsTrait;
use Sylius\Bundle\ResourceBundle\DependencyInjection\Extension\AbstractResourceExtension;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;

final class ProgramariSyliusPifactExtension extends AbstractResourceExtension implements PrependExtensionInterface
{
    use PrependDoctrineMigrationsTrait;

    /** @psalm-suppress UnusedVariable */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../../config'));

        $loader->load('services.xml');
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);
    }

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependDoctrineMigrations($container);
        // I recommend using FileLocator here
        $thirdPartyBundlesViewFileLocator = (new FileLocator(__DIR__ . '/../../templates/bundles/'));

        $container->loadFromExtension('twig', [
            'paths' => [
                $thirdPartyBundlesViewFileLocator->locate('SyliusInvoicingPlugin') => 'SyliusInvoicingPlugin',
                $thirdPartyBundlesViewFileLocator->locate('SyliusShopBundle') => 'SyliusShop',
                $thirdPartyBundlesViewFileLocator->locate('SyliusAdminBundle') => 'SyliusAdmin',
            ],
        ]);
    }

    protected function getMigrationsNamespace(): string
    {
        return 'Programari\SyliusPifactPlugin\Migrations';
    }

    protected function getMigrationsDirectory(): string
    {
        return '@ProgramariSyliusPifactPlugin/src/Migrations';
    }

    protected function getNamespacesOfMigrationsExecutedBefore(): array
    {
        return [
            'Sylius\Bundle\CoreBundle\Migrations',
        ];
    }
}
