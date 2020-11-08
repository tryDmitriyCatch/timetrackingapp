<?php

namespace App\Entity\Traits;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

trait UpdatedAtTrait
{
    /**
     * @var DateTime
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime", name="updated_at", options={"default": "CURRENT_TIMESTAMP"}, nullable=true)
     */
    protected $updatedAt;

    /**
     * @return DateTimeImmutable
     */
    public function getUpdatedAt(): DateTimeImmutable
    {
        return DateTimeImmutable::createFromMutable($this->updatedAt);
    }

    /**
     * @param DateTimeImmutable $updatedAt
     * @return $this
     */
    public function setUpdatedAt(DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = DateTime::createFromImmutable($updatedAt);

        return $this;
    }
}
