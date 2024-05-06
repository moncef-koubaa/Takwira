<?php

namespace App\Entity;

use App\Repository\StadiumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: StadiumRepository::class)]
class Stadium
{
    public static array $citiesAndValues = [
        'Ariana' => 'Ariana',
        'Beja' => 'Beja',
        'Ben Arous' => 'Ben Arous',
        'Bizerte' => 'Bizerte',
        'Gabes' => 'Gabes',
        'Gafsa' => 'Gafsa',
        'Jendouba' => 'Jendouba',
        'Kairouan' => 'Kairouan',
        'Kasserine' => 'Kasserine',
        'Kebili' => 'Kebili',
        'Kef' => 'Kef',
        'Mahdia' => 'Mahdia',
        'Mannouba' => 'Mannouba',
        'Medenine' => 'Medenine',
        'Monastir' => 'Monastir',
        'Nabeul' => 'Nabeul',
        'Sfax' => 'Sfax',
        'Sidi Bouzid' => 'Sidi Bouzid',
        'Siliana' => 'Siliana',
        'Sousse' => 'Sousse',
        'Tataouine' => 'Tataouine',
        'Tozeur' => 'Tozeur',
        'Tunis' => 'Tunis',
        'Zaghouan' => 'Zaghouan',
    ];
    public const CITIES = [
        'Ariana',
        'Beja',
        'Ben Arous',
        'Bizerte',
        'Gabes',
        'Gafsa',
        'Jendouba',
        'Kairouan',
        'Kasserine',
        'Kebili',
        'Kef',
        'Mahdia',
        'Mannouba',
        'Medenine',
        'Monastir',
        'Nabeul',
        'Sfax',
        'Sidi Bouzid',
        'Siliana',
        'Sousse',
        'Tataouine',
        'Tozeur',
        'Tunis',
        'Zaghouan'
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please enter the name of the stadium')]
    #[Assert\Length(max: 50, maxMessage: 'The name of the stadium cannot be longer than 50 characters')]
    private ?string $name = null;


    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'Please enter the opening time of the stadium')]
    private ?\DateTimeInterface $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    #[Assert\NotBlank(message: 'Please enter the closing time of the stadium')]
    private ?\DateTimeInterface $closingTime = null;

    #[ORM\Column]
    #[Assert\Positive]
    private ?float $pricePerHour = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: 'Please enter the city of the stadium')]
    #[Assert\Choice(choices: Stadium::CITIES, message: 'Please select a valid city')]
    private ?string $city = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Please enter the zip code of the stadium')]
    #[Assert\Range(
        notInRangeMessage: 'Please enter a valid zip code',
        min: 1000,
        max: 9999,
    )]
    private ?int $zipCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please enter the address of the stadium')]
    #[Assert\Length(max: 50, maxMessage: 'The address cannot be longer than 255 characters')]
    private ?string $address = null;

    #[ORM\Column]
    private ?bool $hasShower = null;

    #[ORM\Column]
    private ?bool $hasPark = null;

    #[ORM\Column]
    private ?int $ownerId = null;

    #[ORM\ManyToOne(inversedBy: 'stadiums')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $owner = null;

    /**
     * @var Collection<int, Reservation>
     */
    #[ORM\OneToMany(targetEntity: Reservation::class, mappedBy: 'stadium', orphanRemoval: true)]
    private Collection $reservations;

    /**
     * @var Collection<int, Image>
     */
    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: 'stadium', orphanRemoval: true)]
    private Collection $images;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): static
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): static
    {
        $this->closingTime = $closingTime;

        return $this;
    }

    public function getPricePerHour(): ?float
    {
        return $this->pricePerHour;
    }

    public function setPricePerHour(float $pricePerHour): static
    {
        $this->pricePerHour = $pricePerHour;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?int
    {
        return $this->zipCode;
    }

    public function setZipCode(int $zipCode): static
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function hasShower(): ?bool
    {
        return $this->hasShower;
    }

    public function setHasShower(bool $hasShower): static
    {
        $this->hasShower = $hasShower;

        return $this;
    }

    public function hasPark(): ?bool
    {
        return $this->hasPark;
    }

    public function setHasPark(bool $hasPark): static
    {
        $this->hasPark = $hasPark;

        return $this;
    }

    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    public function setOwnerId(int $ownerId): static
    {
        $this->ownerId = $ownerId;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setStadium($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getStadium() === $this) {
                $reservation->setStadium(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Image $image): static
    {
        if (!$this->images->contains($image)) {
            $this->images->add($image);
            $image->setStadium($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getStadium() === $this) {
                $image->setStadium(null);
            }
        }

        return $this;
    }
}