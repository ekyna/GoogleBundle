<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Settings;

use Ekyna\Bundle\GoogleBundle\Form\Type\CodeType;
use Ekyna\Bundle\SettingBundle\Schema\AbstractSchema;
use Ekyna\Bundle\SettingBundle\Schema\SettingBuilder;
use Ekyna\Bundle\UiBundle\Form\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Contracts\Translation\TranslatableInterface;

use function Symfony\Component\Translation\t;

/**
 * Class Schema
 * @package Ekyna\Bundle\GoogleBundle\Settings
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class Schema extends AbstractSchema
{
    public function buildSettings(SettingBuilder $builder): void
    {
        $builder
            // TODO api credentials
            ->setDefaults(array_merge([
                'codes'         => [],
            ], $this->defaults))
            ->setAllowedTypes('codes', ['array']);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('codes', CollectionType::class, [
                'label'        => t('field.tracking', [], 'EkynaGoogle'),
                'entry_type'   => CodeType::class,
                'allow_add'    => true,
                'allow_delete' => true,
            ]);
    }

    public function getLabel(): TranslatableInterface
    {
        return t('settings.label', [], 'EkynaGoogle');
    }

    public function getShowTemplate(): string
    {
        return '@EkynaGoogle/Admin/Settings/show.html.twig';
    }

    public function getFormTemplate(): string
    {
        return '@EkynaGoogle/Admin/Settings/form.html.twig';
    }
}
