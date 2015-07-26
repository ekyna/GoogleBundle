<?php

namespace Ekyna\Bundle\GoogleBundle\Settings;

use Ekyna\Bundle\AdminBundle\Model\SiteAddress;
use Ekyna\Bundle\GoogleBundle\Form\Type\TrackingCodeType;
use Ekyna\Bundle\GoogleBundle\Model\TrackingCode;
use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilderInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints;

/**
 * Class Schema
 * @package Ekyna\Bundle\GoogleBundle\Settings
 * @author Étienne Dauvergne <contact@ekyna.com>
 */
class Schema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilderInterface $builder)
    {
        $builder
            // TODO api credentials
            ->setDefaults(array_merge(array(
                'tracking_code' => new TrackingCode(),
            ), $this->defaults))
            ->setAllowedTypes(array(
                'tracking_code' => 'Ekyna\Bundle\GoogleBundle\Model\TrackingCode',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('tracking_code', new TrackingCodeType())
        ;
    }

    /**
     * {@inheritDoc}
     */
    public function getLabel()
    {
        return 'ekyna_google.settings.label';
    }

    /**
     * {@inheritDoc}
     */
    public function getShowTemplate()
    {
        return 'EkynaGoogleBundle:Admin/Settings:show.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getFormTemplate()
    {
        return 'EkynaGoogleBundle:Admin/Settings:form.html.twig';
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return 'ekyna_google_settings';
    }
}
