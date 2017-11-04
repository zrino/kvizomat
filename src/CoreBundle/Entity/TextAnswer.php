<?php

namespace CoreBundle\Entity;

    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\ORM\Mapping as ORM;

    /**
    * @ORM\Entity
    * @ORM\Table(name="quiz_answers")
    */
    class TextAnswer
    {

        /**
         * @ORM\Id
         * @ORM\Column(type="integer")
         * @ORM\GeneratedValue(strategy="AUTO")
         */
        private $id;

        /**
         * @ORM\ManyToOne(targetEntity="Question", inversedBy="answers")
         * @ORM\JoinColumn(name="id_question", referencedColumnName="id")
         */
        protected $question;

        /** @ORM\Column(type="boolean", name="is_correct") */
        protected $isCorrect;

        /** @ORM\Column(type="string", name="text") */
        private $answer;

        public function __construct()
        {
        }

        public function getAnswer()
        {
            return $this->answer;
        }

        public function setAnswer($answer)
        {
            $this->answer = $answer;
        }

        public function getIsCorrect()
        {
            return $this->isCorrect;
        }

        public function setIsCorrect($correct)
        {
            $this->isCorrect = $correct;
        }

        public function getId()
        {
            return $this->id;
        }

        public function setQuestion(Question $question = null)
        {
            $this->question = $question;

            return $this;
        }

        public function getQuestion()
        {
            return $this->question;
        }
}
