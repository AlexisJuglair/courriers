<?php

namespace App\DataFixtures;

use App\Entity\Courrier;
use App\Entity\Destinataire;
use App\Entity\Suivi;
use Faker\Factory;
use App\Entity\User;
use App\Repository\CourrierRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    protected $hasher;
    protected $courrierRepository;
    protected $em;

    public function __construct(UserPasswordHasherInterface $hasher, CourrierRepository $courrierRepository, EntityManagerInterface $em)
    {
        $this->hasher = $hasher;
        $this->courrierRepository = $courrierRepository;
        $this->em = $em;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");

        $suiviAll = [];

        for ($u=1; $u <= 5 ; $u++) 
        { 
            $user = new User();

            $hash = $this->hasher->hashPassword($user, "password");

            $user->setUsername($faker->userName())
                ->setPassword($hash) 
                ->setTitre($faker->randomElement(["Monsieur","Madame"]))
                ->setNom($faker->lastName()) 
                ->setPrenom($faker->firstName())
                ->setEmail($faker->email())
                ->setTelephone($faker->phoneNumber())
                ->setAdresse($faker->streetAddress())
                ->setCodePostal($faker->postcode())
                ->setLocalite($faker->randomElement(["Paris", "Lyon", "Marseille", "Bordeaux", "Bourg-en-Bresse", "Saint-Denis-lès-Bourg", "Mâcon", "Villars-les-Dombes"]));

            $manager->persist($user);

            for ($d=1; $d <= 10; $d++) 
            { 
                $destinataire = new Destinataire();

                $destinataire->setTitre($faker->randomElement(["Monsieur","Madame"]))
                    ->setNom($faker->lastName()) 
                    ->setPrenom($faker->firstName())
                    ->setFonction($faker->jobTitle())
                    ->setDenomination($faker->company())
                    ->setAdresse($faker->streetAddress())
                    ->setCodePostal($faker->postcode())
                    ->setLocalite($faker->randomElement(["Paris", "Lyon", "Marseille", "Bordeaux", "Bourg-en-Bresse", "Saint-Denis-lès-Bourg", "Mâcon", "Villars-les-Dombes"]))
                    ->setTelephone($faker->phoneNumber())
                    ->setEmail($faker->companyEmail())
                    ->setUtilisateur($user)
                    ->setCommentaire($faker->sentence(10));

                $manager->persist($destinataire);
            }

            for ($c=1; $c <= 20 ; $c++) 
            { 
                $courrier = new Courrier();

                $courrier->setObjet($faker->sentence())
                    ->setOffreReference(strtoupper($faker->randomLetter()).$faker->randomNumber(9, true))
                    ->setDateCreation($faker->dateTimeBetween("-1 years"))
                    ->setDateModification($faker->dateTimeBetween("-10 month"))
                    ->setDateEnvoi($faker->dateTimeBetween("-8 month"))
                    ->setDateRelance($faker->dateTimeBetween("-6 month"))
                    ->setParagraphe1($faker->paragraph())
                    ->setParagraphe2($faker->paragraph())
                    ->setParagraphe3($faker->paragraph())
                    ->setParagraphe4($faker->sentence(10))
                    ->setStatut($faker->randomElement(["Brouillon", "Sélectionné", "Envoyé"]))
                    ->setNosReferences("NOSREF".$faker->randomNumber(4, true))
                    ->setVosReferences("VOSREF".$faker->randomNumber(4, true))
                    ->setAnnonceCopie($faker->randomHtml())
                    ->setUtilisateur($user)
                    ->setDestinataire($destinataire);

                $manager->persist($courrier);

                // $suivi = new Suivi();

                // $suivi->setDate($faker->dateTimeBetween("-4 month"))
                //     ->setObjet($faker->sentence())
                //     ->setCommentaire($faker->sentence(10))
                //     ->setCourrier($courrier);

                // $manager->persist($suivi);

                // array_push($suiviAll, $suivi);
            }
        }

        $manager->flush();
        
        // $query = $this->em->createQuery("SELECT count(c.id) FROM App\Entity\Courrier as c");
        // $countCourrier = $query->getResult()[0][1];

        // $firstCourrier = $this->courrierRepository->findOneBy(array(), array('id' => 'asc'),1,0)->getId();
        // $lastCourrier = $this->courrierRepository->findOneBy(array(), array('id' => 'desc'),1,0)->getId();

        // for ($s=0; $s <= $countCourrier-1; $s++) 
        // { 
        //     while(true)
        //     {
        //         $idPrecedent = rand($firstCourrier, $lastCourrier);
        //         $idSuivant = rand($firstCourrier, $lastCourrier);

        //         if ($idPrecedent != $idSuivant)
        //         {
        //             $courrierPrecedent = $this->courrierRepository->find($idPrecedent);
        //             $courrierSuivant = $this->courrierRepository->find($idSuivant);
                                      
        //             $suiviAll[$s]->setPrecedent($faker->randomElement([$courrierPrecedent, null]))
        //                 ->setSuivant($faker->randomElement([$courrierSuivant, null]));

        //             $manager->persist($suiviAll[$s]);
        //             break;
        //         } 
        //     }
        // }
            
        // $manager->flush();
    }
}
