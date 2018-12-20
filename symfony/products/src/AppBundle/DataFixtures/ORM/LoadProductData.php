<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadProductData extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $product = new Product();
            $product->setTitle('Product '.$i);
            $product->setBrand('Brand '.$i);
            $product->setPrice(mt_rand(10, 100));
            $product->setStock(5);
            $manager->persist($product);
        }

        $manager->flush();
    }

}