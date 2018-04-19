<?php

namespace Ekyna\Bundle\GoogleBundle\DependencyInjection\Compiler;

use Ekyna\Bundle\GoogleBundle\Twig;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class ExtendIvoryMapBundle
 * @package Ekyna\Bundle\GoogleBundle\DependencyInjection\Compiler
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ExtendIvoryMapBundle implements CompilerPassInterface
{
    /**
     * @inheritDoc
     */
    public function process(ContainerBuilder $container)
    {
        $container
            ->getDefinition('ivory.google_map.twig.extension.map')
            ->setClass(Twig\MapExtension::class)
            ->addMethodCall('setMapPool', [new Reference('ekyna_google.map_pool')]);

        $container
            ->getDefinition('ivory.google_map.twig.extension.api')
            ->setClass(Twig\ApiExtension::class)
            ->addMethodCall('setMapPool', [new Reference('ekyna_google.map_pool')]);
    }
}
