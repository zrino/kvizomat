<?php

namespace CoreBundle\Quiz\Entity;

use CoreBundle\User\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quiz",uniqueConstraints={@ORM\UniqueConstraint(name="quiz_unique", columns={"id_user", "title"})})
 */
class Quiz
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", name="title") */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="\CoreBundle\User\Entity\User")
     * @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="Section", mappedBy="quiz", cascade={"persist"})
     */
    private $sections;

    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Quiz
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Add section
     *
     * @param Section $section
     *
     * @return Quiz
     */
    public function addSection(Section $section)
    {
        $this->sections->add($section);

        return $this;
    }

    /**
     * Remove section
     *
     * @param Section $section
     */
    public function removeSection(Section $section)
    {
        $this->sections->removeElement($section);
    }

    /**
     * Get sections
     *
     * @return Collection
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }
}
