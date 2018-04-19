<?php

namespace Ekyna\Bundle\GoogleBundle;

use Ekyna\Bundle\GoogleBundle\DependencyInjection\Compiler\ExtendIvoryMapBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaGoogleBundle
 * @package Ekyna\Bundle\GoogleBundle
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaGoogleBundle extends Bundle
{
    /**
     * @inheritDoc
     */
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new ExtendIvoryMapBundle());
    }
}
