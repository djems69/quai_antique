<?php

namespace App\Entity;

use App\Repository\RestaurantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RestaurantRepository::class)]
class Restaurant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;



    #[ORM\Column]
    private ?int $capacity = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $openingTime = null;

    #[ORM\Column(type: Types::TIME_MUTABLE)]
    private ?\DateTimeInterface $closingTime = null;

    #[ORM\OneToMany(mappedBy: 'Management', targetEntity: Booking::class)]
    private Collection $bookings;


    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $openingTimeNoon = null;

    #[ORM\Column(type: Types::TIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $closingTimeNoon = null;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getCapacity(): ?int
    {
        return $this->capacity;
    }

    public function setCapacity(int $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getOpeningTime(): ?\DateTimeInterface
    {
        return $this->openingTime;
    }

    public function setOpeningTime(\DateTimeInterface $openingTime): self
    {
        $this->openingTime = $openingTime;

        return $this;
    }

    public function getClosingTime(): ?\DateTimeInterface
    {
        return $this->closingTime;
    }

    public function setClosingTime(\DateTimeInterface $closingTime): self
    {
        $this->closingTime = $closingTime;

        return $this;
    }


    /**
     * @return Collection<int, Booking>
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings->add($booking);
            $booking->setManagement($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->removeElement($booking)) {
            // set the owning side to null (unless already changed)
            if ($booking->getManagement() === $this) {
                $booking->setManagement(null);
            }
        }

        return $this;
    }

    public function getOpeningTimeNoon(): ?\DateTimeInterface
    {
        return $this->openingTimeNoon;
    }

    public function setOpeningTimeNoon(?\DateTimeInterface $openingTimeNoon): self
    {
        $this->openingTimeNoon = $openingTimeNoon;

        return $this;
    }

    public function getClosingTimeNoon(): ?\DateTimeInterface
    {
        return $this->closingTimeNoon;
    }

    public function setClosingTimeNoon(?\DateTimeInterface $closingTimeNoon): self
    {
        $this->closingTimeNoon = $closingTimeNoon;

        return $this;
    }


}
