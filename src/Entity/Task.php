<?php

namespace App\Entity;
use App\Entity\Traits\CreatedAtTrait;
use App\Entity\Traits\UpdatedAtTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TaskRepository")
 */
class Task
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
     * @ORM\Column(type="string", length=180, nullable=true)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $timeSpent;

    /**
     * @var User|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userTasks")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

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
     * Get title
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): Task
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get description
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): Task
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get time spent
     *
     * @return integer|null
     */
    public function getTimeSpent(): ?int
    {
        return $this->timeSpent;
    }

    /**
     * Set time spent
     *
     * @param int $timeSpent
     * @return $this
     */
    public function setTimeSpent(int $timeSpent): Task
    {
        $this->timeSpent = $timeSpent;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return self
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
