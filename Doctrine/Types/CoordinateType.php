<?php

namespace Ekyna\Bundle\GoogleBundle\Doctrine\Types;

use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\ArrayType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Ivory\GoogleMap\Base\Coordinate;

/**
 * Class CoordinateType
 * @package Ekyna\Bundle\GoogleBundle\Doctrine\Types
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class CoordinateType extends ArrayType
{
    const COORDINATE = 'coordinate';

    /**
     * {@inheritdoc}
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        $data = parent::convertToPHPValue($value, $platform);
        if (count($data) != 3) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        return new Coordinate($data[0], $data[1], $data[2]);
    }

    /**
     * {@inheritdoc}
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        if (!$value instanceof Coordinate) {
            throw ConversionException::conversionFailed($value, $this->getName());
        }

        $data = array($value->getLatitude(), $value->getLongitude(), $value->isNoWrap());

        return parent::convertToDatabaseValue($data, $platform);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::COORDINATE;
    }
}
