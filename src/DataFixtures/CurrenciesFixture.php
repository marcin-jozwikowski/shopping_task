<?php


namespace App\DataFixtures;


use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

/**
 * Class CurrenciesFixture
 * @package App\DataFixtures
 *
 * Currencies to be used in Products
 */
class CurrenciesFixture extends Fixture
{
    const ALL = [
        ['name' => 'Dollar', 'symbol' => 'USD'],
        ['name' => 'Złoty', 'symbol' => 'PLN'],
        ['name' => 'Euro', 'symbol' => 'EUR']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::ALL as $id => $currency) {
            $curr = new Currency();
            $curr->setName($currency['name']);
            $curr->setSymbol($currency['symbol']);

            $manager->persist($curr);
            $this->addReference('currency-' . $id, $curr);
        }

        $manager->flush();
    }
}