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

    const STATUS_SUBMITTED = 'submitted';
    const STATUS_APPROVED = 'approved';
    const STATUS_DECLINED_SYS = 'decline_sys';
    const STATUS_DECLINED_OWNER = 'decline_owner';
    const STATUS_DECLINED_EXECUTOR = 'decline_executor';

    const STATUS_CHOICE = [
        self::STATUS_SUBMITTED,
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
     * @ORM\Column(type="jsonb")
     */
    #[Assert\NotBlank(message: "The status should not be blank.")]
    #[Assert\Choice (choices: self::STATUS_CHOICE, multiple: true, message: 'Not valid status')]
    private array $status = [];

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
    private ?int $volume;

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

    public function getStatus(): ?array
    {
        $status = $this->status;
        return array_unique($status);
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function addStatus(string $status): self
    {
        $status = strtolower($status);
        if (!in_array($status, $this->status, true)) {
            $this->status[] = $status;
        }
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
