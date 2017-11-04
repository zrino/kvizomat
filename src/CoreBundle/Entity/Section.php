<?php

namespace CoreBundle\Entity;

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
     * @ORM\ManyToOne(targetEntity="Quiz", inversedBy="sections", cascade={"persist"})
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

    public function getId()
    {
        return $this->id;
    }

    public function setSectionText($sectionText)
    {
        $this->sectionText = $sectionText;

        return $this;
    }

    public function getSectionText()
    {
        return $this->sectionText;
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function addQuestion(Question $question)
    {
        $question->setSection($this);
        $this->questions->add($question);

        return $this;
    }

    public function removeQuestion(Question $question)
    {
        $this->questions->removeElement($question);
    }


    public function getQuestions()
    {
        return $this->questions;
    }


    public function setQuiz(Quiz $quiz = null)
    {
        $this->quiz = $quiz;

        return $this;
    }

    public function getQuiz()
    {
        return $this->quiz;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
}
