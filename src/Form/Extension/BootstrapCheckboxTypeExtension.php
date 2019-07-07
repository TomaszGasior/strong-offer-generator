<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class BootstrapCheckboxTypeExtension extends AbstractTypeExtension
{
    public function finishView(FormView $view, FormInterface $form, array $options): void
    {
        $isRadio = $form->getConfig()->getType()->getInnerType() instanceof RadioType;

        $view->vars['label_attr'] += ['class' => ($isRadio ? 'radio' : 'checkbox').'-custom mt-1 mb-1'];
    }

    static public function getExtendedTypes()
    {
        return [CheckboxType::class];
    }
}
