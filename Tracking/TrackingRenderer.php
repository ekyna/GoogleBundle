<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking;

use Ekyna\Bundle\GoogleBundle\Model\Code;
use Ekyna\Bundle\SettingBundle\Manager\SettingManagerInterface;
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
    private Environment             $twig;
    private RequestStack            $requestStack;
    private SettingManagerInterface $settings;
    private TrackingPool            $pool;
    private array                   $config;
    private bool                    $debug;

    private ?TemplateWrapper $template = null;
    /** @var Code[] */
    private ?array $codes = null;

    public function __construct(
        Environment $twig,
        RequestStack $requestStack,
        SettingManagerInterface $settings,
        TrackingPool $pool,
        array $config = [],
        bool $debug = false
    ) {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
        $this->settings = $settings;
        $this->pool = $pool;

        $this->config = array_replace($config, [
            'template' => '@EkynaGoogle/tracking.html.twig',
            'enabled'  => true,
        ]);
        $this->debug = $debug;
    }

    /**
     * Renders the Google tracking script.
     */
    public function render(): string
    {
        if (!$this->config['enabled']) {
            return '';
        }

        if (empty($config = $this->getCodes(Code::TYPE_CONFIG))) {
            return '';
        }

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

        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->getTemplate()->renderBlock($block, [
            'debug'  => $this->debug,
            'config' => $config,
            'events' => $events,
        ]);
    }

    /**
     * Returns the configured Google tracking codes.
     *
     * @return Code[]
     */
    private function getCodes(string $type): array
    {
        if (null === $this->codes) {
            $this->codes = $this->settings->getParameter('google.codes');
        }

        // TODO Warning: Will fetch the wrong code on cross domain XHR
        $request = $this->requestStack->getMainRequest();
        $host = $request->getHost();

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
     */
    private function getTemplate(): TemplateWrapper
    {
        if ($this->template) {
            return $this->template;
        }

        /** @noinspection PhpUnhandledExceptionInspection */
        return $this->template = $this->twig->load($this->config['template']);
    }
}
