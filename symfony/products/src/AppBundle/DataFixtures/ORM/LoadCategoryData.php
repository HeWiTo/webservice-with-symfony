<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCategoryData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $category = new Category();
            $category->setTitle('Category '.$i);
            $category->setCreatedAt(new \DateTime('1987-12-10'));
            $manager->persist($category);
        }

        $manager->flush();
    }

}