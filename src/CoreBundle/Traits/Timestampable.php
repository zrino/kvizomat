<?php

namespace CoreBundle\Traits;

trait Timestampable {

    /**
     * @ORM\Column(type="datetime", name="created_at")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime", name="updated_at")
     */
    private $updated_at;

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

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
       $this->updated_at = new \DateTime();
    }
}

