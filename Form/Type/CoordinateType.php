<?php

namespace Ekyna\Bundle\GoogleBundle\Form\Type;

use Ivory\GoogleMap\Base\Coordinate;
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\Overlay\Marker;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

/**
 * Class CoordinateType
 * @package Ekyna\Bundle\GoogleBundle\Form\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class CoordinateType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latitude', HiddenType::class, [
                'property_path' => $options['latitude_path'],
            ])
            ->add('longitude', HiddenType::class, [
                'property_path' => $options['longitude_path'],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $map = new Map();

        $map->setHtmlId($view->vars['id'] . '_map_canvas');
        $map->setAutoZoom(true);
        $map->setMapOptions([
            'minZoom'          => 3,
            'maxZoom'          => 18,
            'disableDefaultUI' => true,
        ]);
        $map->setStylesheetOptions([
            'width'  => '100%',
            'height' => $options['map_height'] . 'px',
        ]);

        $latitude = null;
        $longitude = null;
        $zoom = 12;

        $data = $form->getData();
        $accessor = PropertyAccess::createPropertyAccessor();

        try {
            $latitude = $accessor->getValue($data, $options['latitude_path']);
            $longitude = $accessor->getValue($data, $options['longitude_path']);
        } catch (ExceptionInterface $e) {
        }

        if (!$latitude && !$longitude) {
            $latitude = 46.52863469527167;
            $longitude = 2.43896484375;
            $zoom = 5;
        }

        $coordinate = new Coordinate($latitude, $longitude);

        $marker = new Marker($coordinate);
        $map->getOverlayManager()->addMarker($marker);
        $map->setCenter($coordinate);
        $map->setMapOption('zoom', $zoom);

        $config = [
            'map_var'    => $map->getVariable(),
            'marker_var' => $marker->getVariable(),
        ];

        $view->vars['map'] = $map;
        $view->vars['config'] = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label'          => 'ekyna_google.field.coordinate',
                'longitude_path' => 'longitude',
                'latitude_path'  => 'latitude',
                'map_height'     => 320,
                'inherit_data'   => true,
                'required'       => false,
            ])
            ->setAllowedTypes('longitude_path', 'string')
            ->setAllowedTypes('latitude_path', 'string')
            ->setAllowedTypes('map_height', 'int');
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'ekyna_google_coordinate';
    }
}
