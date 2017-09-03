<?php

namespace CoreBundle\Traits;

trait Sluggable {

    /**
     * @ORM\Column(type="string", name="slug", nullable=true, unique=true)
     */
    private $slug;

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }

    public function generateSlug() {}
}
