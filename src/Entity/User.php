<?php

namespace App\Entity;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Serializable;
use Symfony\Component\Security\Core\User\UserInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, Serializable
{
    use CreatedAtTrait;
    use UpdatedAtTrait;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string", nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $surname;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Task", mappedBy="user", orphanRemoval=true)
     */
    private $userTasks;

    /**
     * User constructor
     */
    public function __construct()
    {
        $this->userTasks = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get email
     *
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Set roles
     *
     * @param array $roles
     * @return $this
     */
    public function setRoles(array $roles): User
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt() {}

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void {}

    /**
     * Get name
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string|null
     */
    public function getSurname(): ?string
    {
        return $this->surname;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return $this
     */
    public function setSurname(string $surname): User
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * @return string
     */
    public function serialize(): string
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password
        ));
    }

    /**
     * @param $serialized
     */
    public function unserialize($serialized): void
    {
        [
            $this->id,
            $this->email,
            $this->password,
        ] = unserialize($serialized);
    }
}
