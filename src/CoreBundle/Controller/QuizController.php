<?php

namespace CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CoreBundle\Form\TextQuestionType;
use CoreBundle\Form\QuizType;
use CoreBundle\Form\SectionType;
use CoreBundle\Entity\Quiz;
use CoreBundle\Entity\Question;
use CoreBundle\Entity\Section;

class QuizController extends Controller
{

    /**
     * @Route("/quiz/{quiz_id}", name="quiz", requirements={"quiz_id": "\d+"}, defaults={"quiz_id" = 0})
     */
    public function quizAction(Request $request,$quiz_id=0)
    {
        $quiz = new Quiz();
        if((int)$quiz_id!=0)
        {
            $quiz = $this->getDoctrine()->getRepository('CoreBundle:Quiz')->findOneBy(array('id' => $quiz_id));
        }
        $form = $this->createForm(QuizType::class,$quiz);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            try{
                $quiz->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();

                $em->persist($quiz);
                $em->flush();

                $section = new Section();
                $section->setQuiz($quiz);
                $section->setType(1);
                $section->setName("Section 1");

                $em->persist($section);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'notice',
                    'New quiz added!'
                );

                return $this->redirect($request->getUri());
            }
            catch (\Exception $e)
            {
                $this->get('session')->getFlashBag()->add(
                    'warning',
                    'There was an error trying to save your data!'
                );
            }
        }
        $quizList = $this->getDoctrine()->getManager()->getRepository('CoreBundle:Quiz')->findBy(array('user' => $this->getUser()));


        return $this->render('quiz/newquiz.html.twig',array('form' => $form->createView(),
            'quizList' => $quizList, 'quiz' => $quiz));
    }



    /**
     * @Route("/{quiz_slug}/section/{section_id}", name="section", requirements={"section_id": "\d+"}, defaults={"section_id" = 0})
     */
    public function sectionAction(Request $request, $quiz_slug, $section_id = 0)
    {
        try{
            $quiz = $this->getDoctrine()->getRepository('CoreBundle:Quiz')->findOneBy(array('slug' => $quiz_slug));
            if(!$quiz)
            {
                throw $this->createNotFoundException('No quiz found for slug '.$quiz_slug);
            }

            $sectionEnt = new Section();
            if($section_id!=0)
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
                            'notice',
                            'Section updated!'
                        );
                        return $this->redirectToRoute('section', array('quiz_slug' => $quiz_slug,"section_id" => $sectionEnt->getId()));

                    }
                    catch (\Exception $e)
                    {
                        $this->get('session')->getFlashBag()->add(
                            'warning',
                            'There was an error trying to save your data!'
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
        catch(\Exception $e)
        {
            return $e->getMessage();
        }
    }


    /**
     * @Route("/{quiz_slug}/question/{question_id}",name="question", requirements={"question_id": "\d+"}, defaults={"question_id" = 0})
     */
    public function questionAction(Request $request, $quiz_slug, $question_id=0)
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

                #questions
                $questionList = $this->getDoctrine()->getManager()->getRepository('CoreBundle:Question')->findBy(array('section' => $sections));

                $question = $this->createForm(TextQuestionType::class,$questionEnt,array(
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
                            'notice',
                            'New question added!'
                        );

                        return $this->redirectToRoute('question', array('quiz_slug' => $quiz_slug, "question_id" => $questionEnt->getId()));
                    }
                    catch (\Exception $e)
                    {
                        $this->get('session')->getFlashBag()->add(
                            'warning',
                            'There was an error trying to save your data!'
                        );
                    }

                }

                return $this->render('quiz/newquestion.html.twig', array('form' => $question->createView(), "questionList" => $questionList,"quiz" => $quiz));

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