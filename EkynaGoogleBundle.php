<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle;

use Ekyna\Bundle\GoogleBundle\DependencyInjection\Compiler\ExtendIvoryMapBundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class EkynaGoogleBundle
 * @package Ekyna\Bundle\GoogleBundle
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class EkynaGoogleBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ExtendIvoryMapBundle());
    }
}
