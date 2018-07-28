<?php

namespace CoreBundle\Quiz\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="quiz_questions", uniqueConstraints={@ORM\UniqueConstraint(name="question_unique", columns={"id_section", "question_text"})})
 */
class Question
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\Column(type="string", name="question_text") */
    private $questionText;

    /**
     * @ORM\OneToMany(targetEntity="Answer", mappedBy="question", cascade={"persist"})
     */
    private $answers;

    /**
     * @ORM\ManyToOne(targetEntity="Section", inversedBy="questions")
     * @ORM\JoinColumn(name="id_section", referencedColumnName="id")
     */
    private $section;

    /**
     * @ORM\Column(type="integer", name="type")
     */
    private $type;


    public function __construct()
    {
        $this->answers = new ArrayCollection();
    }

    public function getQuestion()
    {
        return $this->questionText;
    }

    public function setQuestion($question)
    {
        $this->questionText = $question;
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
     * Set questionText
     *
     * @param string $questionText
     *
     * @return Question
     */
    public function setQuestionText($questionText)
    {
        $this->questionText = $questionText;

        return $this;
    }

    /**
     * Get questionText
     *
     * @return string
     */
    public function getQuestionText()
    {
        return $this->questionText;
    }

    /**
     * Set type
     *
     * @param integer $type
     *
     * @return Question
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
     * Add answer
     *
     * @param Answer $answer
     *
     * @return Question
     */
    public function addAnswer(Answer $answer)
    {
        $answer->setQuestion($this);
        $this->answers->add($answer);

        return $this;
    }

    /**
     * Remove answer
     *
     * @param Answer $answer
     */
    public function removeAnswer(Answer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set section
     *
     * @param Section $section
     *
     * @return Question
     */
    public function setSection(Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return Section
     */
    public function getSection()
    {
        return $this->section;
    }
}
