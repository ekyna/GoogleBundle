<?php

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
     * @var TrackingRenderer
     */
    protected $renderer;


    /**
     * Constructor.
     *
     * @param TrackingRenderer $renderer
     */
    public function __construct(TrackingRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return [
            new TwigFunction(
                'google_tracking',
                [$this->renderer, 'render'],
                ['is_safe' => ['html']]
            )
        ];
    }
}
