<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Show\Type;

use Ekyna\Bundle\AdminBundle\Show\Type\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class GoogleCodesWidget
 * @package Ekyna\Bundle\GoogleBundle\Show\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class GoogleCodesType extends AbstractType
{
    /**
     * @inheritDoc
     */
    protected function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label'              => 'field.tracking',
            'label_trans_domain' => 'EkynaGoogle',
        ]);
    }

    /**
     * @inheritDoc
     */
    public static function getName(): string
    {
        return 'google_codes';
    }
}
