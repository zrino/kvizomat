<?php

    namespace CoreBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;
    /**
     * @ORM\Entity(repositoryClass="CoreBundle\Repository\QuestionRepository")
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

        public function getId()
        {
            return $this->id;
        }

        public function setQuestionText($questionText)
        {
            $this->questionText = $questionText;

            return $this;
        }

        public function getQuestionText()
        {
            return $this->questionText;
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

        public function addAnswer(TextAnswer $answer)
        {
            $answer->setQuestion($this);
            $this->answers->add($answer);

            return $this;
        }

        public function removeAnswer(TextAnswer $answer)
        {
            $this->answers->removeElement($answer);
        }

        public function getAnswers()
        {
            return $this->answers;
        }

        public function setQuiz(Quiz $quiz = null)
        {
            $this->quiz = $quiz;

            return $this;
        }

        public function setSection(Section $section = null)
        {
            $this->section = $section;

            return $this;
        }

        public function getSection()
        {
            return $this->section;
        }
    }
