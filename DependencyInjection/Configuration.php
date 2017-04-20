<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\GoogleBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $builder = new TreeBuilder('ekyna_google');

        $node = $builder->getRootNode();

        $this->addApiSection($node);
        $this->addClientSection($node);
        $this->addTrackingSection($node);

        return $builder;
    }

    /**
     * Adds the `api` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addApiSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('api')
                    ->isRequired()
                    ->children()
                        ->scalarNode('key')->isRequired()->cannotBeEmpty()->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Adds the `client` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addClientSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('client')
                    ->isRequired()
                    ->children()
                        ->scalarNode('application_name')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('client_id')->end()
                        ->scalarNode('client_secret')->end()
                        ->scalarNode('redirect_uri')->end()
                        ->scalarNode('developer_key')->end()
                    ->end()
                ->end()
            ->end()
        ;
    }

    /**
     * Adds the `tracking` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addTrackingSection(ArrayNodeDefinition $node): void
    {
        $node
            ->children()
                ->arrayNode('tracking')
                    ->canBeDisabled()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('debug')
                            ->defaultValue('%kernel.debug%')
                        ->end()
                        ->scalarNode('template')
                            ->defaultValue('@EkynaGoogle/tracking.html.twig')
                            ->cannotBeEmpty()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
