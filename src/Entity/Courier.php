<?php

namespace App\Entity;

use App\Repository\CourierRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CourierRepository::class)
 */
class Courier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $functionName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $denomination;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nameCompany;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $object;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $offerTitle;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $offerReference;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $place;

    /**
     * @ORM\Column(type="date")
     */
    private $dateCourrier;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraph1;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraph2;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraph3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $paragraph4;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="letters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getFunctionName(): ?string
    {
        return $this->functionName;
    }

    public function setFunctionName(?string $functionName): self
    {
        $this->functionName = $functionName;

        return $this;
    }

    public function getDenomination(): ?string
    {
        return $this->denomination;
    }

    public function setDenomination(?string $denomination): self
    {
        $this->denomination = $denomination;

        return $this;
    }

    public function getNameCompany(): ?string
    {
        return $this->nameCompany;
    }

    public function setNameCompany(?string $nameCompany): self
    {
        $this->nameCompany = $nameCompany;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getOfferTitle(): ?string
    {
        return $this->offerTitle;
    }

    public function setOfferTitle(?string $offerTitle): self
    {
        $this->offerTitle = $offerTitle;

        return $this;
    }

    public function getOfferReference(): ?string
    {
        return $this->offerReference;
    }

    public function setOfferReference(?string $offerReference): self
    {
        $this->offerReference = $offerReference;

        return $this;
    }

    public function getPlace(): ?string
    {
        return $this->place;
    }

    public function setPlace(?string $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getDateCourrier(): ?\DateTimeInterface
    {
        return $this->dateCourrier;
    }

    public function setDateCourrier(\DateTimeInterface $dateCourrier): self
    {
        $this->dateCourrier = $dateCourrier;

        return $this;
    }

    public function getParagraph1(): ?string
    {
        return $this->paragraph1;
    }

    public function setParagraph1(?string $paragraph1): self
    {
        $this->paragraph1 = $paragraph1;

        return $this;
    }

    public function getParagraph2(): ?string
    {
        return $this->paragraph2;
    }

    public function setParagraph2(?string $paragraph2): self
    {
        $this->paragraph2 = $paragraph2;

        return $this;
    }

    public function getParagraph3(): ?string
    {
        return $this->paragraph3;
    }

    public function setParagraph3(?string $paragraph3): self
    {
        $this->paragraph3 = $paragraph3;

        return $this;
    }

    public function getParagraph4(): ?string
    {
        return $this->paragraph4;
    }

    public function setParagraph4(?string $paragraph4): self
    {
        $this->paragraph4 = $paragraph4;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
