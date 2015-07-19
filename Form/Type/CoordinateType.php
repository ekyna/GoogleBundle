<?php

namespace Ekyna\Bundle\GoogleBundle\Form\Type;

use Ivory\GoogleMapBundle\Entity\Marker;
use Ivory\GoogleMapBundle\Model\MapBuilder;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Class CoordinateType
 * @package Ekyna\Bundle\GoogleBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class CoordinateType extends AbstractType
{
    /**
     * @var MapBuilder
     */
    protected $mapBuilder;

    /**
     * @param MapBuilder $mapBuilder
     */
    public function __construct(MapBuilder $mapBuilder)
    {
        $this->mapBuilder = $mapBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latitude', 'hidden')
            ->add('longitude', 'hidden')
        ;

        /*$builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) {
            var_dump($event->getData());
            exit();
        });*/
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $this->mapBuilder->setHtmlContainerId($view->vars['id'].'_map_canvas');
        // $this->mapBuilder->setLanguage(); TODO
        $this->mapBuilder->setAutoZoom(true);
        $this->mapBuilder->setMapOptions(array(
            'minZoom' => 3,
            'maxZoom' => 18,
        ));
        $this->mapBuilder->setStylesheetOptions(array(
            'width' => '100%',
            'height' => '320px',
        ));

        $map = $this->mapBuilder->build();

        $marker = new Marker();
        /** @var \Ivory\GoogleMap\Base\Coordinate $coordinate */
        if (null !== $coordinate = $form->getData()) {
            if (null !== $coordinate->getLatitude() && null !== $coordinate->getLongitude()) {
                $marker->setPosition($coordinate);
            }
        }
        $map->addMarker($marker);

        $config = array(
            'map_var' => $map->getJavascriptVariable(),
            'marker_var' => $marker->getJavascriptVariable(),
        );

        $view->vars['map'] = $map;
        $view->vars['config'] = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'label' => 'ekyna_google.coordinate',
                'data_class' => 'Ivory\GoogleMap\Base\Coordinate',
                'by_reference' => false,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_google_coordinate';
    }
}
