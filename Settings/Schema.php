<?php

namespace Ekyna\Bundle\GoogleBundle\Settings;

use Ekyna\Bundle\CoreBundle\Form\Type\CollectionType;
use Ekyna\Bundle\GoogleBundle\Form\Type\CodeType;
use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingsBuilder;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class Schema
 * @package Ekyna\Bundle\GoogleBundle\Settings
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Schema extends AbstractSchema
{
    /**
     * @inheritDoc
     */
    public function buildSettings(SettingsBuilder $builder)
    {
        $builder
            // TODO api credentials
            ->setDefaults(array_merge([
                'codes'         => [],
                // TODO Remove both
                'tracking_code' => null,
                'property_id'   => null,
            ], $this->defaults))
            ->setAllowedTypes('codes', ['array']);
    }

    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codes', CollectionType::class, [
                'label'        => 'ekyna_google.field.tracking',
                'entry_type'   => CodeType::class,
                'allow_add'    => true,
                'allow_delete' => true,
            ]);
    }

    /**
     * @inheritDoc
     */
    public function getLabel()
    {
        return 'ekyna_google.settings.label';
    }

    /**
     * @inheritDoc
     */
    public function getShowTemplate()
    {
        return '@EkynaGoogle/Admin/Settings/show.html.twig';
    }

    /**
     * @inheritDoc
     */
    public function getFormTemplate()
    {
        return '@EkynaGoogle/Admin/Settings/form.html.twig';
    }
}
