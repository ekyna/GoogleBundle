<?php

namespace Ekyna\Bundle\GoogleBundle\Show\Type;

use Ekyna\Bundle\AdminBundle\Show\Type\AbstractType;
use Ekyna\Bundle\AdminBundle\Show\View;
use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

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
        parent::build($view, $value, $options);

        $latitude = null;
        $longitude = null;
        $zoom = $options['map_zoom'];

        if ($options['latitude'] && $options['longitude']) {
            $latitude = $options['latitude'];
            $longitude = $options['longitude'];
        } else {
            $accessor = PropertyAccess::createPropertyAccessor();

            try {
                $latitude = $accessor->getValue($value, $options['latitude_path']);
                $longitude = $accessor->getValue($value, $options['longitude_path']);
            } catch (ExceptionInterface $e) {
            }
        }

        if (!$latitude && !$longitude) {
            $latitude = 46.52863469527167;
            $longitude = 2.43896484375;
            $zoom = 5;
        }

        $coordinate = new Coordinate($latitude, $longitude);

        $map = new Map();

        if ($options['map_static']) {
            $map->setStaticOptions([
                'width'  => $options['map_width'],
                'height' => $options['map_height'],
            ]);
        } else {
            $map->setHtmlId(empty($options['map_id']) ? 'map_' . uniqid() : $options['map_id']);
            $map->setAutoZoom(true);
            $map->setMapOptions([
                'minZoom'          => 3,
                'maxZoom'          => 18,
                'disableDefaultUI' => true,
            ]);
            $map->setStylesheetOptions([
                'width'         => '100%',
                'height'        => $options['map_height'] . 'px',
            ]);
        }

        $map->getOverlayManager()->addMarker(new Marker($coordinate));
        $map->setCenter($coordinate);
        $map->setMapOption('zoom', $zoom);

        $view->vars['value'] = $map;
        $view->vars['static'] = $options['map_static'];
    }

    /**
     * @inheritDoc
     */
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'longitude'      => null,
                'latitude'       => null,
                'map_id'         => null,
                'map_static'     => true,
                'map_width'      => 640,
                'map_height'     => 320,
                'map_zoom'       => 14,
                'longitude_path' => 'longitude',
                'latitude_path'  => 'latitude',
            ])
            ->setAllowedTypes('longitude', ['number', 'null'])
            ->setAllowedTypes('latitude', ['number', 'null'])
            ->setAllowedTypes('map_id', ['string', 'null'])
            ->setAllowedTypes('map_static', 'bool')
            ->setAllowedTypes('map_width', 'int')
            ->setAllowedTypes('map_height', 'int')
            ->setAllowedTypes('map_zoom', 'int')
            ->setAllowedTypes('longitude_path', 'string')
            ->setAllowedTypes('latitude_path', 'string');
    }

    /**
     * @inheritDoc
     */
    public function getWidgetPrefix()
    {
        return 'google_map';
    }
}