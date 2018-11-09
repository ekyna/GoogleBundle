<?php

namespace Ekyna\Bundle\GoogleBundle\Settings;

use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class Schema
 * @package Ekyna\Bundle\GoogleBundle\Settings
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Schema extends AbstractSchema
{
    /**
     * {@inheritdoc}
     */
    public function buildSettings(SettingsBuilder $builder)
    {
        $builder
            // TODO api credentials
            ->setDefaults(array_merge([
                'tracking_code' => null,
                'property_id' => null,
            ], $this->defaults))
            ->setAllowedTypes('property_id', ['null', 'string']);
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('property_id', TextType::class, [
                'label'    => 'ekyna_google.field.property_id',
                'required' => false,
            ]);
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
}
