<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Html5NumberTypeExtension extends AbstractTypeExtension
{
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['attr'] = $view->vars['attr'] + ['step' => '0.01'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('html5', true);
        $resolver->setDefault('input', 'string');
    }

    static public function getExtendedTypes()
    {
        return [NumberType::class];
    }
}
