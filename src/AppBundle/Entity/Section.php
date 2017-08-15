<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="quiz_sections",uniqueConstraints={@ORM\UniqueConstraint(name="section_unique", columns={"id_quiz", "name"})})
 */
class Section
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", name="section_text", length=500, nullable=true) */
    private $sectionText;

    /**
     * @ORM\OneToMany(targetEntity="Question", mappedBy="section", cascade={"persist"})
     */
    private $questions;

    /**
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="sections")
     * @ORM\JoinColumn(name="id_quiz", referencedColumnName="id")
     */
    private $quiz;

    /**
     * @ORM\Column(type="integer", name="type")
     */
    private $type;

    /**
     * @ORM\Column(type="string", name="name", length=255, nullable=false)
     */
    private $name;


    public function __construct()
    {
        $this->questions = new ArrayCollection();
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
     * Set sectionText
     *
     * @param string $sectionText
     *
     * @return Section
     */
    public function setSectionText($sectionText)
    {
        $this->sectionText = $sectionText;

        return $this;
    }

    /**
     * Get sectionText
     *
     * @return string
     */
    public function getSectionText()
    {
        return $this->sectionText;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Section
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return integer
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Add question
     *
     * @param \AppBundle\Entity\Question $question
     *
     * @return Section
     */
    public function addQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions[] = $question;

        return $this;
    }

    /**
     * Remove question
     *
     * @param \AppBundle\Entity\Question $question
     */
    public function removeQuestion(\AppBundle\Entity\Question $question)
    {
        $this->questions->removeElement($question);
    }

    /**
     * Get questions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuestions()
    {
        return $this->questions;
    }

    /**
     * Set quiz
     *
     * @param \AppBundle\Entity\Quiz $quiz
     *
     * @return Section
     */
    public function setQuiz(\AppBundle\Entity\Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    /**
     * Get quiz
     *
     * @return \AppBundle\Entity\Quiz
     */
    public function getQuiz()
    {
        return $this->quiz;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Section
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
