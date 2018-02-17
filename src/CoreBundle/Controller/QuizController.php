<?php

namespace CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CoreBundle\Form\TextQuestionType;
use CoreBundle\Form\QuizType;
use CoreBundle\Form\SectionType;
use CoreBundle\Entity\Quiz;
use CoreBundle\Entity\Question;
use CoreBundle\Entity\Section;
use Symfony\Component\HttpFoundation\Response;

class QuizController extends BaseController
{

    /**
     * @Route("/quiz/{quiz_id}", name="quiz", requirements={"quiz_id": "\d+"})
     * @param Request $request
     * @param int $quiz_id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function quizAction(Request $request, $quiz_id = 0)
    {
        $user_id = $this->getUser()->getId();

        $quiz = new Quiz();
        if((int)$quiz_id!=0)
        {
            $quiz = $this->getDoctrine()->getRepository('CoreBundle:Quiz')->findOneBy(array('id' => $quiz_id, 'user' => $user_id ));
            if(null === $quiz) {
                return $this->error404();
            }
        }

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try{
                $em = $this->getDoctrine()->getManager();

                $quiz->setUser($this->getUser());

                // always create section if Quiz is new
                $section = new Section();
                $section->setQuiz($quiz);
                $section->setType(1);
                $section->setName("Basic section");
                $quiz->addSection($section);

                $em->persist($quiz);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'changeQuizNotice',
                    [$this::SUCCESS_CODE, 'Changes saved!']
                );

                return $this->redirect($request->getUri());
            }
            catch (\Exception $e)
            {
                $this->get('session')->getFlashBag()->add(
                    'changeQuizNotice',
                    [$this::WARNING_CODE, 'There was an error trying to save your data!']
                );
            }
        }
        $quizList = $this->getDoctrine()->getManager()->getRepository('CoreBundle:Quiz')->findBy(array('user' => $this->getUser()));


        return $this->render('quiz/newquiz.html.twig',array('form' => $form->createView(),
            'quizList' => $quizList, 'quiz' => $quiz));
    }


    /**
     * @Route("/{quiz_slug}/section/{section_id}", name="section", requirements={"section_id": "\d+"})
     * @param Request $request
     * @param $quiz_slug
     * @param int $section_id
     * @return string|\Symfony\Component\HttpFoundation\Response
     */
    public function sectionAction(Request $request, $quiz_slug, $section_id = 0)
    {
        $quiz = $this->getDoctrine()->getRepository(Quiz::class)->findByQuizAndSection($quiz_slug, $section_id);
        if(!$quiz)
        {
            throw $this->createNotFoundException('No quiz found for slug '.$quiz_slug);
        }

        $sectionEnt = new Section();
        if($section_id != 0)
        {
            $sectionEnt = $this->getDoctrine()->getRepository('CoreBundle:Section')->findOneBy(array('id' => $section_id));
        }


        if($quiz->getUser() == $this->getUser() && ($section_id == 0 || ($sectionEnt->getQuiz()->getId() == $quiz->getId())))
        {
            $section = $this->createForm(SectionType::class, $sectionEnt);
            $section->handleRequest($request);

            #questions
            $questionList = $this->getDoctrine()->getManager()->getRepository('CoreBundle:Question')->findBy(array('section' => $sectionEnt->getId()));

            $sectionList =$this->getDoctrine()->getManager()->getRepository('CoreBundle:Section')->findBy(array('quiz' => $quiz->getId()));

            if ($section->isSubmitted() && $section->isValid()) {
                try{

                    $em = $this->getDoctrine()->getManager();
                    $sectionEnt->setType(0);
                    $sectionEnt->setQuiz($quiz);
                    $em->persist($sectionEnt);
                    $em->flush();

                    $this->get('session')->getFlashBag()->add(
                        'changeSectionNotice',
                        [$this::SUCCESS_CODE, 'Changes saved!']
                    );

                    return $this->redirectToRoute('section', array('quiz_slug' => $quiz_slug,"section_id" => $sectionEnt->getId()));

                }
                catch (\Exception $e)
                {
                    $this->get('session')->getFlashBag()->add(
                        'changeSectionNotice',
                        [$this::WARNING_CODE, 'There was an error trying to save your data!']
                    );
                }

            }
            return $this->render('quiz/newsection.html.twig', array('form' => $section->createView(), "questionList" => $questionList,
                "quiz" => $quiz,
                "sectionList" => $sectionList,
                "currentSection" => $sectionEnt));

        }
        else
        {
            throw $this->createAccessDeniedException('Access denied for section '.$section_id);
        }
    }


    /**
     * @Route("/{quiz_slug}/question/{question_id}",name="question", requirements={"question_id": "\d+"})
     * @param Request $request
     * @param $quiz_slug
     * @param int $question_id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function questionAction(Request $request, $quiz_slug, $question_id = 0)
    {
        try{
            $quiz = $this->getDoctrine()->getRepository('CoreBundle:Quiz')->findOneBy(array('slug' => $quiz_slug));
            if(!$quiz)
            {
                throw $this->createNotFoundException('No quiz found for slug ' . $quiz_slug);
            }

            $questionEnt = new Question();
            if($question_id != 0)
            {
                $questionEnt = $this->getDoctrine()->getRepository('CoreBundle:Question')->findOneBy(array('id' => $question_id));
            }

            if($quiz->getUser() == $this->getUser() && ($question_id == 0 || ($questionEnt->getSection()->getQuiz()->getId() == $quiz->getId())))
            {
                #sections
                $sections = $this->getDoctrine()->getRepository('CoreBundle:Section')->findBy(array('id' => $quiz->getSections()->toArray()));

                $question = $this->createForm(TextQuestionType::class,$questionEnt, array(
                    'created_sections' => $sections,
                ));

                $question->handleRequest($request);

                if ($question->isSubmitted() && $question->isValid()) {
                    try{

                        $em = $this->getDoctrine()->getManager();
                        $questionEnt->setType(0);
                        $questionEnt->setQuiz($quiz);
                        $em->persist($questionEnt);
                        $em->flush();

                        $this->get('session')->getFlashBag()->add(
                            'changeQuestionNotice',
                            [$this::SUCCESS_CODE, 'Changes saved!']
                        );

                        return $this->redirectToRoute('question', array('quiz_slug' => $quiz_slug, "question_id" => $questionEnt->getId()));
                    }
                    catch (\Exception $e)
                    {
                        $this->get('session')->getFlashBag()->add(
                            'changeQuestionNotice',
                            [$this::WARNING_CODE, 'There was an error trying to save your data!']
                        );
                    }

                }

                return $this->render('quiz/newquestion.html.twig', ['form' => $question->createView(), "quiz" => $quiz,
                    "sectionList" => $sections]);

            }
            else
            {

                throw $this->createAccessDeniedException('No quiz found for id ' . $quiz_slug);
            }
        }
        catch(\Exception $e)
        {
            echo $e->getMessage();
        }
    }
}

?>