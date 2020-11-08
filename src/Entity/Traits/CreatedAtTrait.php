<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeImmutable;
use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

trait CreatedAtTrait
{
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime", name="created_at", options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    protected $createdAt;

    /**
     * @return DateTimeImmutable
     * Returns createdAt.
     */
    public function getCreatedAt(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->createdAt);
    }

    /**
     * @param DateTimeImmutable $createdAt
     * @return $this
     */
    public function setCreatedAt(DateTimeImmutable $createdAt): self
    {
        $this->createdAt = DateTime::createFromImmutable($createdAt);

        return $this;
    }
}
