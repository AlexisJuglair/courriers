<?php

namespace App\DataFixtures;

use App\Entity\Courier;
use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        for ($u=1; $u <= 5 ; $u++) 
        { 
            $user = new User();

            $hash = $this->hasher->hashPassword($user, "password");

            $user->setUsername($faker->userName())
                ->setPassword($hash) 
                ->setTitle($faker->randomElement(["M.","Mme."]))
                ->setName($faker->lastName()) 
                ->setFirstName($faker->firstName())
                ->setEmail($faker->email())
                ->setPhoneNumber($faker->phoneNumber())
                ->setBirthDate($faker->dateTimeBetween("-60 years", "- 18 years"))
                ->setAddress($faker->streetAddress())
                ->setZipCode($faker->postcode())
                ->setCity($faker->randomElement(["Paris", "Lyon", "Marseille", "Bordeaux", "Bourg-en-Bresse", "Saint-Denis-lès-Bourg", "Mâcon", "Villars-les-Dombes"]))
                ->setLicenses([$faker->randomElement(["A", ""]), $faker->randomElement(["B", ""]), $faker->randomElement(["C", ""])]);

            $manager->persist($user);

            for ($c=1; $c <= 15; $c++) 
            { 
                $courier = new Courier();

                $courier->setTitle($faker->randomElement(["M.","Mme."]))
                    ->setName($faker->lastName()) 
                    ->setFirstName($faker->firstName())
                    ->setFunctionName($faker->jobTitle())
                    ->setdenomination($faker->randomElement(["EURL", "SARL", "SA", "SASU", "SAS", "SNC", "SEM", "SEP", "SCS", "SCA"]))
                    ->setNameCompany($faker->company())
                    ->setAddress($faker->streetAddress())
                    ->setZipCode($faker->postcode())
                    ->setCity($faker->randomElement(["Paris", "Lyon", "Marseille", "Bordeaux", "Bourg-en-Bresse", "Saint-Denis-lès-Bourg", "Mâcon", "Villars-les-Dombes"]))
                    ->setPhoneNumber($faker->phoneNumber())
                    ->setEmail($faker->companyEmail())
                    ->setObject($faker->sentence())
                    ->setOfferTitle(strtoupper($faker->word()))
                    ->setOfferReference(strtoupper($faker->randomLetter()).$faker->randomNumber(9, true))
                    ->setPlace($faker->randomElement(["Paris", "Lyon", "Marseille", "Bordeaux", "Bourg-en-Bresse", "Saint-Denis-lès-Bourg", "Mâcon", "Villars-les-Dombes"]))
                    ->setDateCourrier($faker->dateTimeBetween("-1 years"))
                    ->setParagraph1($faker->realTextBetween(150, 250))
                    ->setParagraph2($faker->realTextBetween(150, 250))
                    ->setParagraph3($faker->realTextBetween(150, 250))
                    ->setParagraph4($faker->realText(100))
                    ->setUser($user);

                $manager->persist($courier);
            }
        }

        $manager->flush();
    }
}
