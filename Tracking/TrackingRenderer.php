<?php

namespace Ekyna\Bundle\GoogleBundle\Tracking;

use Ekyna\Bundle\CookieConsentBundle\Service\Manager;
use Ekyna\Bundle\GoogleBundle\Model\Code;
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
     * @var Manager
     */
    private $consentManager;

    /**
     * @var TrackingPool
     */
    private $pool;

    /**
     * @var array
     */
    private $config;

    /**
     * @var bool
     */
    private $debug;

    /**
     * @var TemplateWrapper
     */
    private $template;

    /**
     * @var Code[]
     */
    private $codes;


    /**
     * Constructor.
     *
     * @param Environment              $twig
     * @param RequestStack             $requestStack
     * @param SettingsManagerInterface $settings
     * @param Manager                  $consentManager
     * @param TrackingPool             $pool
     * @param array                    $config
     * @param bool                     $debug
     */
    public function __construct(
        Environment $twig,
        RequestStack $requestStack,
        SettingsManagerInterface $settings,
        Manager $consentManager,
        TrackingPool $pool,
        array $config = [],
        bool $debug = false
    ) {
        $this->twig           = $twig;
        $this->requestStack   = $requestStack;
        $this->settings       = $settings;
        $this->consentManager = $consentManager;
        $this->pool           = $pool;

        $this->config = array_replace($config, [
            'template' => '@EkynaGoogle/tracking.html.twig',
            'enabled'  => true,
        ]);
        $this->debug  = $debug;
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

        if (empty($config = $this->getCodes(Code::TYPE_CONFIG))) {
            return '';
        }

        /*if (!$this->consentManager->isCategoryAllowed(Category::ANALYTIC)) {
            return '';
        }*/

        $events = $this->pool->getEvents();

        foreach ($events as $event) {
            if ($event->getType() !== Event::PURCHASE) {
                continue;
            }

            if (empty($codes = $this->getCodes(Code::TYPE_CONVERSION))) {
                break;
            }

            foreach ($codes as $code) {
                $event = new Event(Event::CONVERSION);
                $event->setExtra([
                    'send_to' => $code->getValue(),
                ]);

                $events[] = $event;
            }

            break;
        }

        $block = $this->requestStack->getCurrentRequest()->isXmlHttpRequest() ? 'events' : 'init';

        return $this->getTemplate()->renderBlock($block, [
            'debug'  => $this->debug,
            'config' => $config,
            'events' => $events,
        ]);
    }

    /**
     * Returns the configured google tracking codes.
     *
     * @param string $type
     *
     * @return Code[]
     */
    private function getCodes(string $type): array
    {
        if (null === $this->codes) {
            $this->codes = $this->settings->getParameter('google.codes');
        }

        // TODO Warning: Will fetch the wrong code on cross domain XHR
        $request = $this->requestStack->getMasterRequest();
        $host    = $request->getHost();

        return array_filter($this->codes, function (Code $code) use ($type, $host) {
            if ($type !== $code->getType()) {
                return false;
            }

            if (!empty($code->getHost()) && $host !== $code->getHost()) {
                return false;
            }

            return true;
        });
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

        return $this->template = $this->twig->load($this->config['template']);
    }
}
