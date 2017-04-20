<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Tracking;

/**
 * Class TrackingPool
 * @package Ekyna\Bundle\GoogleBundle\Tracking
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class TrackingPool
{
    /** @var Event[] */
    private array $events = [];


    /**
     * Adds the event.
     *
     * @param Event $event
     *
     * @return TrackingPool
     */
    public function addEvent(Event $event): TrackingPool
    {
        $objectId = spl_object_id($event);

        if (!isset($this->events[$objectId])) {
            $this->events[$objectId] = $event;
        }

        return $this;
    }

    /**
     * Returns the events.
     *
     * @return Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
