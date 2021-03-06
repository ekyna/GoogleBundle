<?php

namespace Ekyna\Bundle\GoogleBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TrackingCodeType
 * @package Ekyna\Bundle\GoogleBundle\Form\Type
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class TrackingCodeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('propertyId', 'text', [
                'label' => 'ekyna_google.tracking_code.field.property_id',
                'required' => false,
            ])
            ->add('domain', 'text', [
                'label' => 'ekyna_google.tracking_code.field.domain',
                'required' => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label' => 'ekyna_google.field.tracking_code',
                'data_class' => 'Ekyna\Bundle\GoogleBundle\Model\TrackingCode',
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_google_tracking_code';
    }
}
