<?php

namespace CoreBundle\Quiz\Entity;

use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="quiz_answers")
    */
    class Answer
    {

        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        /**
         * @ORM\ManyToOne(targetEntity="\CoreBundle\Quiz\Entity\Question", inversedBy="answers")
         * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
         */
        protected $question;

        /** @ORM\Column(type="boolean", name="is_correct") */
        protected $isCorrect;

        /** @ORM\Column(type="string", name="text") */
        private $text;

        public function __construct()
        {
        }

        public function getIsCorrect()
        {
            return $this->isCorrect;
        }

        public function setIsCorrect($correct)
        {
            $this->isCorrect = $correct;
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
     * Set question
     *
     * @param Question $question
     *
     * @return Answer
     */
    public function setQuestion(Question $question = null)
    {
        $this->question = $question;

        return $this;
    }

    /**
     * Get question
     *
     * @return Question
     */
    public function getQuestion()
    {
        return $this->question;
    }

        /**
         * @return mixed
         */
        public function getText()
        {
            return $this->text;
        }

        /**
         * @param mixed $text
         */
        public function setText($text): void
        {
            $this->text = $text;
        }
    }
