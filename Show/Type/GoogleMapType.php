<?php

namespace Ekyna\Bundle\GoogleBundle\Show\Type;

use Ekyna\Bundle\AdminBundle\Show\Exception\InvalidArgumentException;
use Ekyna\Bundle\AdminBundle\Show\Type\AbstractType;
use Ekyna\Bundle\AdminBundle\Show\View;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlays\Marker;

/**
 * Class GoogleMapType
 * @package Ekyna\Bundle\GoogleBundle\Show\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class GoogleMapType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function build(View $view, $value, array $options = [])
    {
        if ($value && !$value instanceof Coordinate) {
            throw new InvalidArgumentException("Expected instance of " . Coordinate::class);
        }

        parent::build($view, $value, $options);

        $map = new Map();
        $map->setAutoZoom(true);
        $map->setMapOptions([
            'minZoom'          => 3,
            'maxZoom'          => 18,
            'disableDefaultUI' => true,
        ]);
        $map->setStylesheetOptions([
            'width'  => '100%',
            'height' => '320px',
        ]);

        if (null !== $value && null !== $value->getLatitude() && null !== $value->getLongitude()) {
            $marker = new Marker();
            $marker->setPosition($value);
            $map->addMarker($marker);
        }

        $view->vars['value'] = $map;
    }

    /**
     * @inheritDoc
     */
    public function getWidgetPrefix()
    {
        return 'google_map';
    }
}