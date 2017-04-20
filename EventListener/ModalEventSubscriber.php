<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\EventListener;

use Ekyna\Bundle\GoogleBundle\Tracking\TrackingRenderer;
use Ekyna\Bundle\UiBundle\Event\ModalEvent;
use Ekyna\Bundle\UiBundle\Model\Modal;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ModalEventSubscriber
 * @package Ekyna\Bundle\GoogleBundle\EventListener
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ModalEventSubscriber implements EventSubscriberInterface
{
    protected TrackingRenderer $renderer;


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
     * Modal response event handler.
     *
     * @param ModalEvent $event
     */
    public function onModalResponse(ModalEvent $event): void
    {
        $modal = $event->getModal();

        if ($modal->getContentType() === Modal::CONTENT_DATA) {
            return;
        }

        $vars = $modal->getVars();
        if (!isset($vars['extra_content'])) {
            $vars['extra_content'] = '';
        }
        $vars['extra_content'] .= $this->renderer->render();

        $modal->setVars($vars);
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents(): array
    {
        return [
            ModalEvent::MODAL_RESPONSE => ['onModalResponse', 0],
        ];
    }
}
