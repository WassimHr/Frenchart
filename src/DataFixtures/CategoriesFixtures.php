<?php

namespace App\DataFixtures;

use App\Entity\Categories;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategoriesFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
         $category = new Categories();
         $category->setName('Sculture');
         $category->setSlug('sculture');
         $manager->persist($category);

         $category = new Categories();
         $category->setName('Peinture');
         $category->setSlug('peinture');
         $manager->persist($category);

         $category = new Categories();
         $category->setName('Photographie');
         $category->setSlug('photographie');
         $manager->persist($category);

        $manager->flush();
    }
}
