<?php

namespace Ekyna\Bundle\GoogleBundle\Tracking;

use Ekyna\Bundle\SettingBundle\Manager\SettingsManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Environment;
use Twig\TemplateWrapper;

/**
 * Class TrackingRenderer
 * @package Ekyna\Bundle\GoogleBundle\Tracking
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class TrackingRenderer
{
    /**
     * @var Environment
     */
    private $twig;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var SettingsManagerInterface
     */
    private $settings;

    /**
     * @var TrackingPool
     */
    private $pool;

    /**
     * @var array
     */
    private $config;

    /**
     * @var TemplateWrapper
     */
    private $template;

    /**
     * @var string
     */
    private $propertyId;


    /**
     * Constructor.
     *
     * @param Environment              $twig
     * @param RequestStack             $requestStack
     * @param SettingsManagerInterface $settings
     * @param TrackingPool             $pool
     * @param array                    $config
     */
    public function __construct(
        Environment $twig,
        RequestStack $requestStack,
        SettingsManagerInterface $settings,
        TrackingPool $pool,
        array $config = []
    ) {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
        $this->settings = $settings;
        $this->pool = $pool;

        $this->config = array_replace($config, [
            'template' => '@EkynaGoogle/tracking.html.twig',
            'enabled'  => true,
            'debug'    => false,
        ]);
    }

    /**
     * Renders the google tracking script.
     *
     * @return string
     */
    public function render()
    {
        if (!$this->config['enabled']) {
            return '';
        }

        if (!$id = $this->getGoogleTracking()) {
            return '';
        }

        $block = $this->requestStack->getCurrentRequest()->isXmlHttpRequest() ? 'events' : 'init';

        return $this->getTemplate()->renderBlock($block, [
            'code'   => $id,
            'debug'  => $this->config['debug'],
            'events' => $this->pool->getEvents(),
        ]);
    }

    /**
     * Returns the configured google property id.
     *
     * @return string
     */
    private function getGoogleTracking()
    {
        if (null !== $this->propertyId) {
            return $this->propertyId;
        }

        $this->propertyId = $this->settings->getParameter('google.property_id');

        if (empty($this->propertyId)) {
            $this->propertyId = false;
        }

        return $this->propertyId;
    }

    /**
     * Returns the template.
     *
     * @return TemplateWrapper
     */
    private function getTemplate()
    {
        if ($this->template) {
            return $this->template;
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->template = $this->twig->load($this->config['template']);
    }
}
