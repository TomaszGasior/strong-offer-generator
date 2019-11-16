<?php

namespace App\Form;

use App\Entity\Author;
use App\Entity\Discount;
use App\Entity\Item;
use App\Model\Offer;
use App\Util\Formatter;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeneratorJobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('author', EntityType::class, [
                'label' => 'Osoba wystawiająca',
                'class' => Author::class,
                'choice_label' => 'name',
                'required' => false, /* show empty element */
            ])
            ->add('recipient_company', TextType::class, [
                'property_path' => 'recipient.company',
                'label' => 'Firma',
            ])
            ->add('recipient_name', TextType::class, [
                'property_path' => 'recipient.name',
                'label' => 'Imię i nazwisko',
                'required' => false,
            ])
            ->add('expirationDate', DateType::class, [
                'label' => 'Data ważności',
                'widget' => 'single_text',
            ])
            ->add('items', EntityType::class, [
                'label' => 'Pozycje',
                'class' => Item::class,
                'choice_label' => function(Item $item){
                    return sprintf(
                        '%s (%s)',
                        $item->getName(),
                        Formatter::formatPrice($item->getPrice())
                    );
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('discounts', EntityType::class, [
                'label' => 'Rabaty',
                'class' => Discount::class,
                'choice_label' => function(Discount $discount){
                    return sprintf(
                        '%s (%s)',
                        $discount->getName(),
                        Formatter::formatDiscountValue($discount)
                    );
                },
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

    public function getBlockPrefix(): string
    {
        // Generator controller sets GET method on this form to make possible to save
        // offer settings as URL. Remove block prefix to make that URL shorter.
        return '';
    }
}
