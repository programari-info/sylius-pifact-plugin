<?php

declare(strict_types=1);

namespace Programari\SyliusPifactPlugin\DependencyInjection;

use Programari\SyliusPifactPlugin\Entity\PifactInvoice;
use Programari\SyliusPifactPlugin\Entity\PifactInvoiceInterface;
use Programari\SyliusPifactPlugin\Repository\PifactInvoiceRepository;
use Sylius\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

final class Configuration implements ConfigurationInterface
{
    /**
     * @psalm-suppress UnusedVariable
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('programari_sylius_pifact');
        $rootNode = $treeBuilder->getRootNode();
        $this->addResourcesSection($rootNode);
        return $treeBuilder;
    }


    private function addResourcesSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('resources')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('pifact_invoice')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->variableNode('options')->end()
                    ->arrayNode('classes')
                        ->addDefaultsIfNotSet()
                        ->children()
                        ->scalarNode('model')->defaultValue(PifactInvoice::class)->cannotBeEmpty()->end()
                        ->scalarNode('interface')->defaultValue(PifactInvoiceInterface::class)->cannotBeEmpty()->end()
                        ->scalarNode('controller')->defaultValue(ResourceController::class)->cannotBeEmpty()->end()
                        ->scalarNode('repository')->defaultValue(PifactInvoiceRepository::class)->cannotBeEmpty()->end()
                    ->end()
                    ->end()
                    ->end()
                    ->end()
                ->end()
                ->end()
            ->end()
        ;
    }
}
