<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Discount;
use App\Entity\Item;
use App\Offer\Offer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneratorJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', TextType::class, [
                'label' => 'Firma',
            ])
            ->add('author', EntityType::class, [
                'label' => 'Osoba wystawiająca',
                'class' => Author::class,
                'choice_label' => 'name',
                'required' => false, /* show empty element */
            ])
            ->add('items', EntityType::class, [
                'label' => 'Pozycje',
                'class' => Item::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('discounts', EntityType::class, [
                'label' => 'Rabaty',
                'class' => Discount::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('generate', SubmitType::class, [
                'label' => 'Generuj dokument PDF',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offer::class,
        ]);
    }
}
