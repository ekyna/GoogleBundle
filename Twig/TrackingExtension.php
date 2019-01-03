<?php

namespace Ekyna\Bundle\GoogleBundle\Twig;

use Ekyna\Bundle\GoogleBundle\Tracking\TrackingRenderer;

/**
 * Class TrackingExtension
 * @package Ekyna\Bundle\GoogleBundle\Twig
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TrackingExtension extends \Twig_Extension
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
            new \Twig_SimpleFunction(
                'google_tracking',
                [$this->renderer, 'render'],
                ['is_safe' => ['html']]
            )
        ];
    }
}
