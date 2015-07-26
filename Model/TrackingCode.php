<?php

namespace Ekyna\Bundle\GoogleBundle\Model;

/**
 * Class TrackingCode
 * @package Ekyna\Bundle\GoogleBundle\Model
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TrackingCode
{
    /**
     * @var string
     */
    protected $propertyId;

    /**
     * @var string
     */
    protected $domain = 'auto';


    /**
     * Sets the propertyId.
     *
     * @param string $propertyId
     * @return TrackingCode
     */
    public function setPropertyId($propertyId = null)
    {
        $this->propertyId = $propertyId;
        return $this;
    }

    /**
     * Returns the propertyId.
     *
     * @return string
     */
    public function getPropertyId()
    {
        return $this->propertyId;
    }

    /**
     * Sets the domain.
     *
     * @param string $domain
     * @return TrackingCode
     */
    public function setDomain($domain = null)
    {
        $this->domain = $domain;
        return $this;
    }

    /**
     * Returns the domain.
     *
     * @return string
     */
    public function getDomain()
    {
        return $this->domain;
    }
}
