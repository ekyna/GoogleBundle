<?php

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
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_google');

        $this->addClientSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds the client section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addClientSection(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('client')
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
}
