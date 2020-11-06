<?php

namespace Ekyna\Bundle\GoogleBundle\Form\Type;

use Ekyna\Bundle\GoogleBundle\Model\Code;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CodeType
 * @package Ekyna\Bundle\GoogleBundle\Form\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class CodeType extends AbstractType
{
    /**
     * @inheritDoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('value', TextType::class, [
                'label' => 'ekyna_core.field.value',
                'attr'  => [
                    'placeholder' => 'ekyna_core.field.value',
                ],
            ])
            ->add('host', TextType::class, [
                'label'    => 'ekyna_core.field.host',
                'attr'     => [
                    'placeholder' => 'ekyna_core.field.host',
                ],
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label'   => 'ekyna_core.field.type',
                'choices' => Code::getTypes(),
                'attr'    => [
                    'placeholder' => 'ekyna_core.field.type',
                ],
            ]);
    }

    /**
     * @inheritDoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', Code::class);
    }

    /**
     * @inheritDoc
     */
    public function getBlockPrefix()
    {
        return 'ekyna_google_code';
    }
}
