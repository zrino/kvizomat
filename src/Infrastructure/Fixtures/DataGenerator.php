<?php

namespace Infrastructure\Fixtures;

use CoreBundle\Quiz\Entity\Answer;
use CoreBundle\Quiz\Entity\Question;
use CoreBundle\Quiz\Entity\Quiz;
use CoreBundle\Quiz\Enum\QuestionTypeEnum;
use CoreBundle\Quiz\Entity\Section;
use CoreBundle\User\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class DataGenerator extends Command
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        parent::__construct();
    }

    public function configure()
    {
        $this
            ->setName('kvizomat:generate_data')
            ->addArgument('user', InputArgument::REQUIRED, 'User for which quiz is being generated')
            ->addOption('number', 'l', InputOption::VALUE_OPTIONAL, 'Number of quizzes to generate', 1);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $numberOfQuizzes = $input->getOption('number');
        $username = $input->getArgument('user');
        try {
            $this->generateQuizzesForUser($username, $numberOfQuizzes);
        } catch (Exception $e) {
            $output->writeln('Error: ' . $e->getMessage());
        }

        $output->writeln('Sucessfully generated data!');
    }

    /**
     * @param string $username
     * @param int $numberOfQuizzes
     * @throws Exception
     */
    public function generateQuizzesForUser(string $username, int $numberOfQuizzes)
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if (null === $user) {
            throw new Exception('User not found!');
        }

        $numberOfSections = rand(0, 2);

        for ($i = 0; $i < $numberOfQuizzes; $i++)
        {
            $quiz = new Quiz();
            $quiz->setUser($user);
            $quiz->setTitle('This is my quiz' . $i);

            for ($j = 0; $j < $numberOfSections; $j++)
            {
                $section = new Section();
                $section->setName('Section ' . $j);
                $section->setQuiz($quiz);
                if (rand(0,1) > 0) {
                    $section->setSectionText('This is some section text. Update it so its not boring');
                }

                $section->setType(0); #TODO: check the fucki  this?

                $numberOfQuestions = rand(5, 15);

                for ($k = 0; $k < $numberOfQuestions; $k++)
                {
                    $question = new Question();
                    $question->setQuestionText('Whats updog?');

                    $question->setType(QuestionTypeEnum::QUESTION_WITH_OFFERED_ANSWERS);
                    $question->setSection($section);

                    $numberOfAnswers = rand(3, 6);

                    if (QuestionTypeEnum::QUESTION_WITH_OFFERED_ANSWERS === $question->getType()) {
                        for ($l= 0; $l < $numberOfAnswers; $l++) {
                            $answer = new Answer();
                            $answer->setText('Well, this must be the correct one');
                            $answer->setQuestion($question);
                            if (rand(0, 3) === 1) {
                                $answer->setIsCorrect(true);
                            }
                            $question->addAnswer($answer);
                        }
                    }
                    $section->addQuestion($question);
                }
                $quiz->addSection($section);
            }
            $this->entityManager->persist($quiz);
        }
        $this->entityManager->flush();
    }
}