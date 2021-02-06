<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 * @UniqueEntity(fields={"name"}, message="There is already an account with this username")
 */
abstract class EntityKind
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected ?int $id = null;

    /**
     * @ORM\Column(type="string", length=150, unique=true)
     */
    #[
        Assert\NotBlank(message: "The username should not be blank."),
        Assert\Length(
            min: 3,
            max: 150,
            minMessage: "The adr name must be at least {{ limit }} characters long",
            maxMessage: "The adr name cannot be longer than {{ limit }} characters"
        )
    ]
    protected ?string $name;

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
}