<?php

    namespace CoreBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    use CoreBundle\Traits\Sluggable;
    use CoreBundle\Traits\Timestampable;
    use Symfony\Component\Validator\Constraints as Assert;
    /**
     * @ORM\Entity
     * @ORM\Table(name="quiz",uniqueConstraints={@ORM\UniqueConstraint(name="quiz_unique", columns={"id_user", "title"})})
     *
     * @ORM\HasLifecycleCallbacks()
     */

    class Quiz
    {
        use Sluggable;
        use Timestampable;
        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        /** @ORM\Column(type="string", name="title")
         * @Assert\NotBlank() */
        private $title;

        /**
         * @ORM\ManyToOne(targetEntity="User", cascade={"persist"})
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
         * @param \CoreBundle\Entity\Section $section
         *
         * @return Quiz
         */
        public function addSection(Section $section)
        {
            $section->setQuiz($this);
            $this->sections->add($section);

            return $this;
        }

        /**
         * Set user
         *
         * @param \CoreBundle\Entity\User $user
         *
         * @return Quiz
         */
        public function setUser(User $user = null)
        {
            $this->user = $user;

            return $this;
        }

        /**
         * Get user
         *
         * @return \CoreBundle\Entity\User
         */
        public function getUser()
        {
            return $this->user;
        }

        /**
         * Remove section
         *
         * @param \CoreBundle\Entity\Section $section
         */
        public function removeSection(Section $section)
        {
            $this->sections->removeElement($section);
        }

        /**
         * Get sections
         *
         * @return \Doctrine\Common\Collections\Collection
         */
        public function getSections()
        {
            return $this->sections;
        }

        /**
         * @ORM\PrePersist
         */
        public function generateSlug()
        {
            $this->slug = strtolower(implode("-", explode(" ", $this->title)));

        }
}
