<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`users`")
 * @UniqueEntity(fields={"username"}, message="There is already an account with this username")
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 * @UniqueEntity(fields={"phone"}, message="There is already an account with this phone")
 */
class User extends Entity implements UserInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';

    const ROLE_CHOICE = [
        self::ROLE_USER,
        self::ROLE_ADMIN,
    ];

    const STATUS_NEW = 'STATUS_NEW';
    const STATUS_VERIFIED = 'STATUS_VERIFIED';
    const STATUS_DELETE = 'STATUS_DELETE';

    const STATUS_CHOICE = [
        self::STATUS_NEW,
        self::STATUS_VERIFIED,
        self::STATUS_DELETE
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    #[
        Assert\NotBlank(message: "The username should not be blank."),
        Assert\Length(
            min: 3,
            max: 180,
            minMessage: "Your username must be at least {{ limit }} characters long",
            maxMessage: "Your username cannot be longer than {{ limit }} characters",
        )
    ]
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    #[
        Assert\NotBlank(message: "The roles should not be blank."),
        Assert\Choice(
            choices: User::ROLE_CHOICE,
            multiple: true,
            message: "Not valid role"
        )
    ]
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var string|null The hashed password
     */
    #[
        Assert\NotBlank(message: "The password should not be blank.", groups: ["set-password"]),
        Assert\Length(
            min: 3,
            max: 180,
            minMessage: "Your password must be at least {{ limit }} characters long",
            maxMessage: "Your password cannot be longer than {{ limit }} characters",
            groups: ["set-password"]
        )
    ]
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=180)
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
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[
        Assert\NotBlank(message: "The name should not be blank."),
        Assert\Length(
            min: 3,
            max: 50,
            minMessage: "Your first name must be at least {{ limit }} characters long",
            maxMessage: "Your first name cannot be longer than {{ limit }} characters",
        )
    ]
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[
        Assert\NotBlank(message: "The username should not be blank."),
        Assert\Length(
            min: 3,
            max: 50,
            minMessage: "Your first name must be at least {{ limit }} characters long",
            maxMessage: "Your first name cannot be longer than {{ limit }} characters"
        )
    ]
    private $surname;

    /**
     * @ORM\Column(type="string", length=20)
     */
    #[
        Assert\NotBlank(message: "The phone should not be blank."),
        Assert\Length (
            min: 8,
            max: 20,
            minMessage: "Your phone must be at least {{ limit }} characters long",
            maxMessage: "Your phone cannot be longer than {{ limit }} characters",
        )
    ]
    private $phone;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[Assert\Choice(choices: User::STATUS_CHOICE, message: "Not valid status"), Assert\NotBlank]
    private $status;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function addRole(string $role): self
    { $role = strtoupper($role);

        if (!in_array($role, $this->roles, true)) {
            $this->roles[] = $role;
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }

    /**
     * @param string|null $plainPassword
     * @return User
     */
    public function setPlainPassword(?string $plainPassword): User
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
         $this->plainPassword = null;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

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
}
