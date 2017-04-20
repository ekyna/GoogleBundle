<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ekyna\Bundle\GoogleBundle\Tracking\TrackingRenderer;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * Class TrackingExtension
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TrackingExtension extends AbstractExtension
{
    /**
     * @inheritDoc
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'google_tracking',
                [TrackingRenderer::class, 'render'],
                ['is_safe' => ['html']]
            )
        ];
    }
}
