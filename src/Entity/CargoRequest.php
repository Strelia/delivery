<?php

namespace App\Entity;

use App\Repository\CargoRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CargoRequestRepository::class)
 */
class CargoRequest
{
    const STATUS_PUBLISHED = 'published';
    const STATUS_REJECTED = 'rejected';
    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED_SYS = 'decline_sys';
    const STATUS_DECLINED_OWNER = 'decline_owner';
    const STATUS_DECLINED_EXECUTOR = 'decline_executor';

    const STATUS_CHOICE = [
        self::STATUS_SUBMITTED,
        self::STATUS_REJECTED,
        self::STATUS_PUBLISHED,
        self::STATUS_APPROVED,
        self::STATUS_DECLINED_SYS,
        self::STATUS_DECLINED_OWNER,
        self::STATUS_DECLINED_EXECUTOR,
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\ManyToOne(targetEntity=Cargo::class, inversedBy="cargoRequest")
     * @ORM\JoinColumn(nullable=false)
     */
//    #[Assert\NotBlank(message: 'The cargo should not be blank.')]
    private ?Cargo $cargo;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="CargoRequests")
     * @ORM\JoinColumn(nullable=false)
     */
//    #[Assert\NotBlank(message: 'The executor should not be blank.')]
    private ?Business $executor;

    /**
     * @ORM\Column(type="string", length=40, options={"default": self::STATUS_PUBLISHED})
     */
    #[Assert\Choice (choices: self::STATUS_CHOICE, message: 'Not valid status')]
    private string $status = self::STATUS_PUBLISHED;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Assert\NotBlank (message: "The price should not be blank.")]
    private ?int $price;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[Assert\NotBlank (message: "The weight should not be blank.")]
    private ?int $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $volume;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private ?string $note = null;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotNull (message: "The is vat should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $isEditable = false;

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
