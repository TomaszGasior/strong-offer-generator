<?php

namespace App\Form;

use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ItemEditType extends AbstractType
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
            ->add('price', null, [
                'label' => 'Cena',
            ])
            ->add('position', null, [
                'label' => 'Numer sortowania',
                'help' => 'Im większa liczba, tym wyżej ta pozycja znajdzie się w wygenerowanej ofercie.',
            ])
            ->add('enabledByDefault', null, [
                'label' => 'Domyślnie zaznaczaj tę pozycję przy tworzeniu oferty',
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Zapisz pozycję',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
