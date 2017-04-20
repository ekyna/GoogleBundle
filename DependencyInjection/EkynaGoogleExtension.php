<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\DependencyInjection;

use Ekyna\Bundle\ResourceBundle\DependencyInjection\PrependBundleConfigTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader;

/**
 * Class EkynaGoogleExtension
 * @package Ekyna\Bundle\GoogleBundle\DependencyInjection
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaGoogleExtension extends Extension implements PrependExtensionInterface
{
    use PrependBundleConfigTrait;

    public function prepend(ContainerBuilder $container): void
    {
        $this->prependBundleConfigFiles($container);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\PhpFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.php');

        $container->setParameter('ekyna_google.api_key', $config['api']['key']);

        // Duplicate with config/packages/google_apiclient.yaml
        $container
            ->getDefinition('ekyna_google.client')
            ->replaceArgument(0, $config['client']);

        $container
            ->getDefinition('ekyna_google.tracking.renderer')
            ->replaceArgument(4, $config['tracking']);
    }
}
