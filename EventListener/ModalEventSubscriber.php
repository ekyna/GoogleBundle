<?php

namespace Ekyna\Bundle\GoogleBundle\EventListener;

use Ekyna\Bundle\CoreBundle\Event\ModalEvent;
use Ekyna\Bundle\CoreBundle\Modal\Modal;
use Ekyna\Bundle\GoogleBundle\Tracking\TrackingRenderer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class ModalEventSubscriber
 * @package Ekyna\Bundle\GoogleBundle\EventListener
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ModalEventSubscriber implements EventSubscriberInterface
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
     * Modal response event handler.
     *
     * @param ModalEvent $event
     */
    public function onModalResponse(ModalEvent $event)
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
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return [
            ModalEvent::MODAL_RESPONSE => ['onModalResponse', 0],
        ];
    }
}
