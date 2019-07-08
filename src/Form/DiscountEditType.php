<?php

namespace App\Form;

use App\Entity\Discount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscountEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Nazwa',
            ])
            ->add('visualName', null, [
                'label' => 'Nazwa w ofercie',
                'help' => 'Ta nazwa jest widoczna tylko w wygenerowanej ofercie. Jeśli jej brak, używana jest główna nazwa.',
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Rodzaj rabatu',
                'choices' => [
                    'Zmniejszaj o taką kwotę' => Discount::TYPE_STATIC,
                    'Zmniejszaj o tyle procent' => Discount::TYPE_PERCENT,
                ],
                'expanded' => true,
            ])
            ->add('value', null, [
                'label' => 'Wartość',
            ])
            ->add('position', null, [
                'label' => 'Numer sortowania',
                'help' => 'Im większa liczba, tym wyżej ten rabat znajdzie się w wygenerowanej ofercie.',
            ])
            ->add('enabledByDefault', null, [
                'label' => 'Domyślnie zaznaczaj ten rabat przy tworzeniu oferty',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz rabat',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Discount::class,
        ]);
    }
}
