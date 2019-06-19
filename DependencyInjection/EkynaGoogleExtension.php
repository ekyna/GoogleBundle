<?php

namespace Ekyna\Bundle\GoogleBundle\DependencyInjection;

use Ekyna\Bundle\CoreBundle\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaGoogleExtension
 * @package Ekyna\Bundle\GoogleBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaGoogleExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        $container
            ->getDefinition('ekyna_google.client')
            ->replaceArgument(0, $config['client']);

        $container
            ->getDefinition('ekyna_google.tracking.renderer')
            ->replaceArgument(5, $config['tracking']);
    }
}
