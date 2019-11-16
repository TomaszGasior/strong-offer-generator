<?php

namespace App\Form;

use App\Entity\Author;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AuthorEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', null, [
                'label' => 'Imię i nazwisko',
            ])
            ->add('title', null, [
                'label' => 'Tytuł',
            ])
            ->add('email', null, [
                'label' => 'Adres e-mail',
            ])
            ->add('phone', null, [
                'label' => 'Numer telefonu',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Author::class,
        ]);
    }
}
