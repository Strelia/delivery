<?php

namespace App\Entity;

use App\Repository\CargoRequestRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CargoRequestRepository::class)
 */
class CargoRequest
{
    const STATUS_PUBLISHED = 'STATUS_PUBLISHED';
    const STATUS_APPROVED = 'STATUS_APPROVED';
    const STATUS_DECLINED = 'STATUS_DECLINED';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Cargo::class, inversedBy="CargoRequest")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cargo;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="CargoRequests")
     * @ORM\JoinColumn(nullable=false)
     */
    private $executor;

    /**
     * @ORM\Column(type="string", length=40, options={"default": self::STATUS_PUBLISHED})
     */
    private string $status = self::STATUS_PUBLISHED;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $volume;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $note = null;

    /**
     * @ORM\Column(type="boolean", options={"default": false})
     */
    private $isEditable;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCargo(): ?Cargo
    {
        return $this->cargo;
    }

    public function setCargo(?Cargo $cargo): self
    {
        $this->cargo = $cargo;

        return $this;
    }

    public function getExecutor(): ?Business
    {
        return $this->executor;
    }

    public function setExecutor(?Business $executor): self
    {
        $this->executor = $executor;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getVolume(): ?int
    {
        return $this->volume;
    }

    public function setVolume(?int $volume): self
    {
        $this->volume = $volume;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getIsEditable(): ?bool
    {
        return $this->isEditable;
    }

    public function setIsEditable(bool $isEditable): self
    {
        $this->isEditable = $isEditable;

        return $this;
    }
}
