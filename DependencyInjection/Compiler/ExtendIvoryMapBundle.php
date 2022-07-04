<?php

declare(strict_types=1);

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
    public function process(ContainerBuilder $container): void
    {
        $container
            ->getDefinition('ivory.google_map.twig.extension.map')
            ->setClass(Twig\MapExtension::class)
            ->addMethodCall('setMapPool', [new Reference('ekyna_google.map.pool')]);

        $container
            ->getDefinition('ivory.google_map.twig.extension.api')
            ->setClass(Twig\ApiExtension::class)
            ->addMethodCall('setMapPool', [new Reference('ekyna_google.map.pool')]);

        if (!$container->has('ivory.google_map.serializer.loader')) {
            return;
        }

        $container
            ->getDefinition('ivory.google_map.serializer.loader')
            ->replaceArgument(0, '%kernel.project_dir%/vendor/ivory/google-map/src/Service/Serializer');
    }
}
