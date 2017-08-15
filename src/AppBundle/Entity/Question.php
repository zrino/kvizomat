<?php

    namespace AppBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    /**
     * @ORM\Entity
     * @ORM\Table(name="quiz_questions",uniqueConstraints={@ORM\UniqueConstraint(name="question_unique", columns={"id_section", "question_text"})})
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
         * @ORM\OneToMany(targetEntity="TextAnswer", mappedBy="question", cascade={"persist"})
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
     * @param \AppBundle\Entity\TextAnswer $answer
     *
     * @return Question
     */
    public function addAnswer(\AppBundle\Entity\TextAnswer $answer)
    {
        $answer->setQuestion($this);

        $this->answers->add($answer);

        return $this;
    }

    /**
     * Remove answer
     *
     * @param \AppBundle\Entity\TextAnswer $answer
     */
    public function removeAnswer(\AppBundle\Entity\TextAnswer $answer)
    {
        $this->answers->removeElement($answer);
    }

    /**
     * Get answers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAnswers()
    {
        return $this->answers;
    }

    /**
     * Set quiz
     *
     * @param \AppBundle\Entity\Quiz $quiz
     *
     * @return Question
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
     * Set section
     *
     * @param \AppBundle\Entity\Section $section
     *
     * @return Question
     */
    public function setSection(\AppBundle\Entity\Section $section = null)
    {
        $this->section = $section;

        return $this;
    }

    /**
     * Get section
     *
     * @return \AppBundle\Entity\Section
     */
    public function getSection()
    {
        return $this->section;
    }
}
