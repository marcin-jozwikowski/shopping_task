<?php


namespace App\DataFixtures;


use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

/**
 * Class ProductsFixture
 * @package App\DataFixtures
 *
 * Dummy products
 */
class ProductsFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $currencyCount = count(CurrenciesFixture::ALL);

        for ($id = 1; $id < 200; $id++) {
            $product = new Product();
            $product->setName('Product ' . $id);
            $product->setPrice(2 + $id % 30);
            $product->setDescription('Description of ' . $id);
            $product->setCurrency($this->getReference('currency-' . $id % $currencyCount));

            $manager->persist($product);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CurrenciesFixture::class
        ];
    }
}