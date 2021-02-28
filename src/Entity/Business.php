<?php

namespace App\Entity;

use App\Repository\BusinessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=BusinessRepository::class)
 * @ORM\Table (name="businesses")
 */

#[UniqueEntity(fields: ['name'], message: 'There is already an account with this username')]
#[ApiResource(
    collectionOperations: ['get' => ['normalization_context' => ['groups'=> 'business:list']]],
    itemOperations: [
        'get' => ['normalization_context' => ['groups'=> 'business:item']]
    ],
    paginationEnabled: true
)]
class Business extends Entity
{

    const STATUS_CHOICE = [
        self::STATUS_NEW,
        self::STATUS_CONFIRM,
        self::STATUS_REMOVED,
        self::STATUS_BAN,
    ];

    const STATUS_NEW = 'STATUS_NEW';
    const STATUS_CONFIRM = 'STATUS_CONFIRM';
    const STATUS_REMOVED = 'STATUS_REMOVED';
    const STATUS_BAN = 'STATUS_BAN';

    const OCCUPATIONS_CHOICE = [
        self::OCCUPATIONS_CARGO_OWNER,
        self::OCCUPATIONS_CAR_OWNER,
    ];

    const OCCUPATIONS_CARGO_OWNER = 'OCCUPATIONS_CARGO_OWNER';
    const OCCUPATIONS_CAR_OWNER = 'OCCUPATIONS_CAR_OWNER';

    const AGENCY_TYPE_CHOICE = [
        self::AGENCY_NATURAL_PERSON,
        self::AGENCY_JURIDICAL_PERSON,
    ];

    const AGENCY_NATURAL_PERSON = 'AGENCY_NATURAL_PERSON';
    const AGENCY_JURIDICAL_PERSON = 'AGENCY_JURIDICAL_PERSON';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    #[Groups(['business:item', 'business:list'])]
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     */
    #[
        Assert\NotBlank(message: "The name should not be blank."),
        Assert\Length(
            min: 3,
            max: 255,
            minMessage: "Your company name must be at least {{ limit }} characters long",
            maxMessage: "Your company name cannot be longer than {{ limit }} characters"
        )
    ]
    private ?string $name = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[
        Assert\NotBlank(allowNull: true),
        Assert\Length(
            min: 3,
            max: 255,
            minMessage: "Your international name must be at least {{ limit }} characters long",
            maxMessage: "Your international name cannot be longer than {{ limit }} characters"
        )
    ]
    private ?string $internationalName = null;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    #[
        Assert\NotBlank(allowNull: true),
        Assert\Length(
            min: 3,
            max: 150,
            minMessage: "Your brand must be at least {{ limit }} characters long",
            maxMessage: "Your brand cannot be longer than {{ limit }} characters"
        )
    ]
    private ?string $brand = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[
        Assert\Length(
            min: 10,
            max: 255,
            minMessage: "Your address must be at least {{ limit }} characters long",
            maxMessage: "Your address cannot be longer than {{ limit }} characters"
        )
    ]
    private ?string $address = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    #[
        Assert\NotBlank(allowNull: true),
        Assert\Url (
            message: "The url \"{{ value }}\" is not a valid url",
        )
    ]
    private ?string $webURL = null;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private ?string $logo = null;

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[
        Assert\NotBlank(message: "The status should not be blank."),
        Assert\Choice(
            choices: self::STATUS_CHOICE,
            message: "Not valid status"
        )
    ]
    private ?string $status;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="company")
     */
    private ArrayCollection|PersistentCollection  $staff;

    /**
     * @ORM\Column(type="jsonb")
     */
    #[
        Assert\NotBlank(message: "The status should not be blank."),
        Assert\Choice(
            choices: self::OCCUPATIONS_CHOICE,
            multiple: true,
            message: "Not valid occupations"
        )
    ]
    private array $occupations = [];

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[
        Assert\NotBlank(message: "The status should not be blank."),
        Assert\Choice(
            choices: self::AGENCY_TYPE_CHOICE,
            message: "Not valid agency type"
        )
    ]
    private ?string $agencyType;

    /**
     * @ORM\OneToMany(targetEntity=Cargo::class, mappedBy="owner", orphanRemoval=true)
     */
    private ArrayCollection|PersistentCollection $cargo;

    /**
     * @ORM\Column(type="string", length=150)
     */
    #[
        Assert\NotBlank(message: "The email should not be blank."),
        Assert\Email(message: "The email '{{ value }}' is not a valid email."),
        Assert\Length(
            min: 3,
            max: 180,
            minMessage: "Your email must be at least {{ limit }} characters long",
            maxMessage: "Your email cannot be longer than {{ limit }} characters",
        )
    ]
    private ?string $email;

    /**
     * @ORM\OneToMany(targetEntity=RequestCargo::class, mappedBy="executor", fetch="EXTRA_LAZY")
     */
    private $requestCargos;

    public function __construct()
    {
        $this->staff = new ArrayCollection();
        $this->cargo = new ArrayCollection();
        $this->requestCargos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getInternationalName(): ?string
    {
        return $this->internationalName;
    }

    public function setInternationalName(?string $internationalName): self
    {
        $this->internationalName = $internationalName;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): self
    {
        $this->brand = $brand;

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

    public function getWebURL(): ?string
    {
        return $this->webURL;
    }

    public function setWebURL(?string $webURL): self
    {
        $this->webURL = $webURL;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

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

    /**
     * @return Collection|User[]
     */
    public function getStaff(): Collection|array
    {
        return $this->staff;
    }

    public function addStaff(User $staff): self
    {
        if (!$this->staff->contains($staff)) {
            $this->staff[] = $staff;
            $staff->setCompany($this);
        }

        return $this;
    }

    public function removeStaff(User $staff): self
    {
        if ($this->staff->removeElement($staff)) {
            // set the owning side to null (unless already changed)
            if ($staff->getCompany() === $this) {
                $staff->setCompany(null);
            }
        }

        return $this;
    }

    public function getOccupations(): ?array
    {
        return $this->occupations;
    }

    public function setOccupations(array $occupations): self
    {
        $this->occupations = $occupations;

        return $this;
    }

    public function getAgencyType(): ?string
    {
        return $this->agencyType;
    }

    public function setAgencyType(string $agencyType): self
    {
        $this->agencyType = $agencyType;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection|Cargo[]
     */
    public function getCargo(): Collection
    {
        return $this->cargo;
    }

    public function addCargo(Cargo $cargo): self
    {
        if (!$this->cargo->contains($cargo)) {
            $this->cargo[] = $cargo;
            $cargo->setOwner($this);
        }

        return $this;
    }

    public function removeCargo(Cargo $cargo): self
    {
        if ($this->cargo->removeElement($cargo)) {
            // set the owning side to null (unless already changed)
            if ($cargo->getOwner() === $this) {
                $cargo->setOwner(null);
            }
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|RequestCargo[]
     */
    public function getRequestCargos(): Collection
    {
        return $this->requestCargos;
    }

    public function addRequestCargo(RequestCargo $requestCargo): self
    {
        if (!$this->requestCargos->contains($requestCargo)) {
            $this->requestCargos[] = $requestCargo;
            $requestCargo->setExecutor($this);
        }

        return $this;
    }

    public function removeRequestCargo(RequestCargo $requestCargo): self
    {
        if ($this->requestCargos->removeElement($requestCargo)) {
            // set the owning side to null (unless already changed)
            if ($requestCargo->getExecutor() === $this) {
                $requestCargo->setExecutor(null);
            }
        }

        return $this;
    }
}
