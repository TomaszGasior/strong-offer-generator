<?php

namespace App\DataFixtures;

use App\Entity\Author;
use App\Entity\Discount;
use App\Entity\Item;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Provider\Base;

class AppFixtures extends Fixture
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('pl_PL');
    }

    public function load(ObjectManager $manager)
    {
        $f = $this->faker;

        for ($i=0; $i < 3; $i++) {
            $author = new Author;

            $author->setName($f->firstName . ' ' . $f->lastName);
            $author->setEmail($f->safeEmail);
            $author->setPhone($f->phoneNumber);

            $manager->persist($author);
        }

        $discount = new Discount;
        $discount->setName('Rabat za odnośnik w stopce');
        $discount->setValue(100);
        $discount->setType(Discount::TYPE_STATIC);
        $discount->setPosition(1);
        $manager->persist($discount);

        $discount = new Discount;
        $discount->setName('Rabat za zapłatę z góry');
        $discount->setValue(10);
        $discount->setType(Discount::TYPE_PERCENT);
        $discount->setPosition(10);
        $discount->setEnabledByDefault(true);
        $manager->persist($discount);

        $itemsNames = [
            'Gotowy motyw graficzny',
            'Dedykowany projekt graficzny',
            'Galeria zdjęć',
            'Galeria zaawansowana — zdjęcia i wideo',
            'Blog lub aktualności',
            'Formularz kontaktowy',
            'Mapa Google',
            'Widżet Facebooka',
            'Integracja z Google Analytics',
            'Hosting na 12 miesięcy',
            'Certyfikat zabezpieczeń SSL',
        ];

        foreach ($itemsNames as $i => $itemName) {
            $item = new Item;

            $item->setName($itemName);
            $item->setPrice($f->randomFloat(2, 90, 3000));
            $item->setEnabledByDefault($i < 4);
            if ($f->boolean(75)) {
                $item->setPosition($f->numberBetween(1, 50));
            }

            $manager->persist($item);
        }

        $manager->flush();
    }
}
