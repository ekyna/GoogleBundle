<?php

declare(strict_types=1);

namespace Ekyna\Bundle\GoogleBundle\Form\Type;

use Ekyna\Bundle\GoogleBundle\Model\Code;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use function Symfony\Component\Translation\t;

/**
 * Class CodeType
 * @package Ekyna\Bundle\GoogleBundle\Form\Type
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class CodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', TextType::class, [
                'label' => t('field.value', [], 'EkynaUi'),
                'attr'  => [
                    'placeholder' => t('field.value', [], 'EkynaUi'),
                ],
            ])
            ->add('host', TextType::class, [
                'label'    => t('field.host', [], 'EkynaUi'),
                'attr'     => [
                    'placeholder' => t('field.host', [], 'EkynaUi'),
                ],
                'required' => false,
            ])
            ->add('type', ChoiceType::class, [
                'label'                     => t('field.type', [], 'EkynaUi'),
                'choices'                   => Code::getTypes(),
                'choice_translation_domain' => false,
                'attr'                      => [
                    'placeholder' => t('field.type', [], 'EkynaUi'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefault('data_class', Code::class);
    }

    public function getBlockPrefix(): string
    {
        return 'ekyna_google_code';
    }
}
