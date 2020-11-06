<?php

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
    protected function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('label', 'ekyna_google.field.tracking');
    }

    /**
     * @inheritDoc
     */
    public function getWidgetPrefix()
    {
        return 'google_codes';
    }
}
