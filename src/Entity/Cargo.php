<?php

namespace App\Entity;

use App\Repository\CargoRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use JetBrains\PhpStorm\Pure;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CargoRepository::class)
 * @ORM\Table(name="cargo")
 */
class Cargo extends Entity
{
    const STATUS_CHOICE = [
        self::STATUS_OPEN,
        self::STATUS_CLOSE,
    ];

    const STATUS_OPEN = 'STATUS_OPEN';
    const STATUS_CLOSE = 'STATUS_CLOSE';

    const PREPAYMENT_TYPE_CHOICE = [
        self::PREPAYMENT_TYPE_FUEL,
        self::PREPAYMENT_TYPE_CASH,
    ];

    const PREPAYMENT_TYPE_FUEL = 'PREPAYMENT_TYPE_FUEL';
    const PREPAYMENT_TYPE_CASH = 'PREPAYMENT_TYPE_CASH';

    const PAYMENT_TYPE_FIXED = "PAYMENT_TYPE_FIXED";
    const PAYMENT_TYPE_PER_KILOMETER = "PAYMENT_TYPE_PER_KILOMETER";

    const PAYMENT_TYPE_CHOICE =[
        self::PAYMENT_TYPE_FIXED,
        self::PAYMENT_TYPE_PER_KILOMETER
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private ?string $name;

    /**
     * @ORM\ManyToOne(targetEntity=Business::class, inversedBy="cargo")
     * @ORM\JoinColumn(nullable=false)
     */
    private ?Business $owner = null;

    /**
     * @ORM\Column(type="integer")
     */
    #[
        Assert\Range(
            notInRangeMessage: "You must be between {{ min }} weight and {{ max }}tone tall to enter",
            min: 1,
            max: 400
        )
    ]
    private ?int $weight;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    #[
        Assert\Range(
            notInRangeMessage: "You must be between {{ min }} volume and {{ max }}tone tall to enter",
            min: 1,
            max: 400
        )
    ]
    private ?int $volume;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $length;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $width;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $diameter;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $countBelt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[
        Assert\NotBlank(message: "The address from should not be blank.")
    ]
    private ?string $addressFrom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    #[
        Assert\NotBlank(message: "The address from should not be blank.")
    ]
    private ?string $addressTo;

    /**
     * @ORM\ManyToOne(targetEntity=Adr::class)
     */
    private ?Adr $adr = null;

    /**
     * @ORM\ManyToMany(targetEntity=CarBodyKind::class)
     */
    private ArrayCollection|PersistentCollection $carBodies;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank(message: "The has hitch should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $hasHitch;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank(message: "The has ruber tyres should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $hasRuberTyres;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank(message: "The has hook should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $hasHook;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank(message: "The is tir should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $isTir;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank(message: "The is CMR should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $isCMR;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank(message: "The is T1 should not be blank."),
        Assert\Type(type: "bool")
    ]
    private ?bool $isT1;

    /**
     * @ORM\Column(type="integer")
     */
    #[
        Assert\NotBlank(message: "The has hook should not be blank."),
        Assert\Range(
            notInRangeMessage: "The count cars must be greater than {{ min }}",
            min: 1
        )
    ]
    private ?int $countCars;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $dateStartMin;

    /**
     * @ORM\Column(type="date")
     */
    private ?DateTimeInterface $dateStartMax;

    /**
     * @ORM\Column(type="integer")
     */
    #[
        Assert\NotBlank (message: "The price should not be blank.")
    ]
    private ?int $price;

    /**
     * @ORM\Column(type="string", length=150)
     */
    #[
        Assert\NotBlank(message: "The payment kind should not be blank."),
        Assert\Choice(
            choices: self::PAYMENT_TYPE_CHOICE,
            message: "Not valid payment kind"
        )
    ]
    private ?string $paymentKind;

    /**
     * @ORM\Column(type="boolean")
     */
    #[
        Assert\NotBlank (message: "The is vat should not be blank.")
    ]
    private ?bool $isVat;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    #[
        Assert\Choice(
            choices: self::PREPAYMENT_TYPE_CHOICE,
            message: "Not valid prepayment kind"
        )
    ]
    private ?string $prepaymentKind;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $prepayment;

    /**
     * @ORM\Column(type="boolean")
     */
    private ?bool $isHiddenUserRequest;

    /**
     * @ORM\Column(type="string", length=15)
     */
    #[
        Assert\Choice(
            choices: self::STATUS_CHOICE,
            message: "Not valid status"
        )
    ]
    private ?string $status;

    /**
     * @ORM\ManyToMany(targetEntity=LoadingKind::class)
     * @ORM\JoinTable(name="cargo_loading_kinds",
     *     joinColumns={@ORM\JoinColumn(name="load_kind_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="cargo_id", referencedColumnName="id", unique=true)}
     * )
     */
    private ArrayCollection|PersistentCollection $loadingKinds;

    /**
     * @ORM\ManyToMany(targetEntity=LoadingKind::class)
     * @ORM\JoinTable(name="cargo_unloading_kinds",
     *     joinColumns={@ORM\JoinColumn(name="load_kind_id", referencedColumnName="id")},
     *     inverseJoinColumns={@ORM\JoinColumn(name="cargo_id", referencedColumnName="id", unique=true)}
     * )
     */
    private ArrayCollection|PersistentCollection $unloadingKinds;

    /**
     * @ORM\ManyToOne(targetEntity=PackagingKind::class)
     */
    private ?PackagingKind $packagingKind;

    public function __construct()
    {
        $this->carBodies = new ArrayCollection();
        $this->loadingKinds = new ArrayCollection();
        $this->unloadingKinds = new ArrayCollection();

        $this->hasHitch = false;
        $this->hasRuberTyres = false;
        $this->hasHook = false;
        $this->isTir = false;
        $this->isCMR = false;
        $this->isT1 = false;
        $this->isVat = false;
        $this->isHiddenUserRequest = false;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?Business
    {
        return $this->owner;
    }

    public function setOwner(?Business $owner): self
    {
        $this->owner = $owner;

        return $this;
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

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function setWidth(?int $width): self
    {
        $this->width = $width;

        return $this;
    }

    public function getLength(): ?int
    {
        return $this->length;
    }

    public function setLength(?int $length): self
    {
        $this->length = $length;

        return $this;
    }

    public function getDiameter(): ?int
    {
        return $this->diameter;
    }

    public function setDiameter(?int $diameter): self
    {
        $this->diameter = $diameter;

        return $this;
    }

    public function getCountBelt(): ?int
    {
        return $this->countBelt;
    }

    public function setCountBelt(?int $countBelt): self
    {
        $this->countBelt = $countBelt;

        return $this;
    }

    public function getAddressFrom(): ?string
    {
        return $this->addressFrom;
    }

    public function setAddressFrom(string $addressFrom): self
    {
        $this->addressFrom = $addressFrom;

        return $this;
    }

    public function getAddressTo(): ?string
    {
        return $this->addressTo;
    }

    public function setAddressTo(string $addressTo): self
    {
        $this->addressTo = $addressTo;

        return $this;
    }

    public function getAdr(): ?Adr
    {
        return $this->adr;
    }

    public function setAdr(?Adr $adr): self
    {
        $this->adr = $adr;

        return $this;
    }

    /**
     * @return Collection|CarBodyKind[]
     */
    public function getCarBodies(): Collection
    {
        return $this->carBodies;
    }

    public function addCarBody(CarBodyKind $carBody): self
    {
        if (!$this->carBodies->contains($carBody)) {
            $this->carBodies[] = $carBody;
        }

        return $this;
    }

    public function removeCarBody(CarBodyKind $carBody): self
    {
        $this->carBodies->removeElement($carBody);

        return $this;
    }

    public function getHasHitch(): ?bool
    {
        return $this->hasHitch;
    }

    public function setHasHitch(bool $hasHitch): self
    {
        $this->hasHitch = $hasHitch;

        return $this;
    }

    public function getHasRuberTyres(): ?bool
    {
        return $this->hasRuberTyres;
    }

    public function setHasRuberTyres(bool $hasRuberTyres): self
    {
        $this->hasRuberTyres = $hasRuberTyres;

        return $this;
    }

    public function getHasHook(): ?bool
    {
        return $this->hasHook;
    }

    public function setHasHook(bool $hasHook): self
    {
        $this->hasHook = $hasHook;

        return $this;
    }

    public function getIsTir(): ?bool
    {
        return $this->isTir;
    }

    public function setIsTir(bool $isTir): self
    {
        $this->isTir = $isTir;

        return $this;
    }

    public function getIsCMR(): ?bool
    {
        return $this->isCMR;
    }

    public function setIsCMR(bool $isCMR): self
    {
        $this->isCMR = $isCMR;

        return $this;
    }

    public function getIsT1(): ?bool
    {
        return $this->isT1;
    }

    public function setIsT1(bool $isT1): self
    {
        $this->isT1 = $isT1;

        return $this;
    }

    public function getCountCars(): ?int
    {
        return $this->countCars;
    }

    public function setCountCars(int $countCars): self
    {
        $this->countCars = $countCars;

        return $this;
    }

    public function getDateStartMin(): ?DateTimeInterface
    {
        return $this->dateStartMin;
    }

    public function setDateStartMin(DateTimeInterface $dateStartMin): self
    {
        $this->dateStartMin = $dateStartMin;

        return $this;
    }

    public function getDateStartMax(): ?DateTimeInterface
    {
        return $this->dateStartMax;
    }

    public function setDateStartMax(DateTimeInterface $dateStartMax): self
    {
        $this->dateStartMax = $dateStartMax;

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

    public function getPaymentKind(): ?string
    {
        return $this->paymentKind;
    }

    public function setPaymentKind(?string $paymentKind): self
    {
        $this->paymentKind = $paymentKind;

        return $this;
    }

    public function getIsVat(): ?bool
    {
        return $this->isVat;
    }

    public function setIsVat(bool $isVat): self
    {
        $this->isVat = $isVat;

        return $this;
    }

    public function getPrepaymentKind(): ?string
    {
        return $this->prepaymentKind;
    }

    public function setPrepaymentKind(?string $prepaymentKind): self
    {
        $this->prepaymentKind = $prepaymentKind;

        return $this;
    }

    public function getPrepayment(): ?int
    {
        return $this->prepayment;
    }

    public function setPrepayment(?int $prepayment): self
    {
        $this->prepayment = $prepayment;

        return $this;
    }

    public function getIsHiddenUserRequest(): ?bool
    {
        return $this->isHiddenUserRequest;
    }

    public function setIsHiddenUserRequest(bool $isHiddenUserRequest): self
    {
        $this->isHiddenUserRequest = $isHiddenUserRequest;

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
     * @return Collection|LoadingKind[]
     */
    public function getLoadingKinds(): Collection
    {
        return $this->loadingKinds;
    }

    public function addLoadingKind(LoadingKind $loadingKind): self
    {
        if (!$this->loadingKinds->contains($loadingKind)) {
            $this->loadingKinds[] = $loadingKind;
        }

        return $this;
    }

    public function removeLoadingKind(LoadingKind $loadingKind): self
    {
        $this->loadingKinds->removeElement($loadingKind);

        return $this;
    }

    /**
     * @return Collection|LoadingKind[]
     */
    public function getUnloadingKinds(): Collection
    {
        return $this->unloadingKinds;
    }

    public function addUnloadingType(LoadingKind $unloadingType): self
    {
        if (!$this->unloadingKinds->contains($unloadingType)) {
            $this->unloadingKinds[] = $unloadingType;
        }

        return $this;
    }

    public function removeUnloadingType(LoadingKind $unloadingType): self
    {
        $this->unloadingKinds->removeElement($unloadingType);

        return $this;
    }

    public function getPackagingKind(): ?PackagingKind
    {
        return $this->packagingKind;
    }

    public function setPackagingKind(?PackagingKind $packagingKind): self
    {
        $this->packagingKind = $packagingKind;

        return $this;
    }
}
