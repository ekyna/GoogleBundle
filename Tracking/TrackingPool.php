<?php

namespace Ekyna\Bundle\GoogleBundle\Tracking;

/**
 * Class TrackingPool
 * @package Ekyna\Bundle\GoogleBundle\Tracking
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class TrackingPool
{
    /**
     * @var Event[]
     */
    private $events;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->events = [];
    }

    /**
     * Adds the event.
     *
     * @param Event $event
     *
     * @return TrackingPool
     */
    public function addEvent(Event $event)
    {
        $id = spl_object_id($event);

        if (!isset($this->events[$id])) {
            $this->events[$id] = $event;
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
