<?php

namespace CoreBundle\Traits;

trait Timestampable {

    /**
     * @ORM\Column(type="date", name="created_at")
     * @Assert\NotNull()
     */
    private $created_at;

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function generateCreatedAt()
    {
       $this->created_at = new \DateTime();
    }
}

