<?php


namespace AppBundle\DataFixtures\ORM;

use CoreBundle\Entity\Question;
use CoreBundle\Entity\Quiz;
use CoreBundle\Entity\Section;
use CoreBundle\Entity\TextAnswer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class LoadQuiz extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = $this->getReference("admin-user");
        // create 5 Quizzes! Bam!
        for ($i = 0; $i < 5; $i++) {
            $quiz[] = new Quiz();
            $quiz[$i]->setTitle('Quiz' . $i);
            $quiz[$i]->setUser($user);

            $numOfSections = rand(1, 8);
            for($j = 0; $j < $numOfSections; $j++)
            {
                $section[] = new Section();
                $section[$j]->setName("Section" . $j);
                $section[$j]->setType(1);
                $this->setOptionalAttribute($section[$j], 'setSectionText', "Lorem ipsum dolor sit" . $j);

                $numOfQuestions = rand(1, 10);
                for($k = 0; $k < $numOfQuestions; $k++)
                {
                    $question[] = new Question();
                    $question[$k]->setQuestionText("What does the fox say?" . $k);
                    $question[$k]->setType(1);

                    $numOfAnswers = rand(1, 6);
                    for($l = 0; $l < $numOfAnswers; $l++)
                    {
                        $answers[] = new TextAnswer();
                        $answers[$l]->setIsCorrect((bool) rand(0, 1));
                        $answers[$l]->setAnswer("The thing goes skraaaa ripiti PAPA");

                        $question[$k]->addAnswer($answers[$l]);

                    }
                    unset($answers);
                    $section[$j]->addQuestion($question[$k]);

                }
                unset($question);
                $quiz[$i]->addSection($section[$j]);

            }
            unset($section);
            $manager->persist($quiz[$i]);
        }

        $manager->flush();
    }

    public function setOptionalAttribute($obj, $func, $parameters)
    {
        $toSet = (bool) rand(0,1);
        if(true === $toSet)
            call_user_func([$obj, $func], $parameters);
        return;
    }
}