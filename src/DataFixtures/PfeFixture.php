<?php

namespace App\DataFixtures;

use App\Entity\Entreprise;
use App\Entity\Pfe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class PfeFixture extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker=Factory::create();
        for ($i=0;$i<20;$i++){
            $pfe=new Pfe();
            $pfe->setTitre("Pfe ".$i);
            $pfe->setNom($faker->firstName.' '.$faker->name);
            $entreprise=new Entreprise();
            $entreprise->setDesignation($faker->company);
            $manager->persist($entreprise);
            $pfe->setEntreprise($entreprise);
            $manager->persist($pfe);
        }
        $manager->flush();
    }
}
