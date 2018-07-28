<?php

namespace CoreBundle\Quiz\Controller\Front;

use CoreBundle\Quiz\Entity\Question;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends Controller
{
    /**
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @param int $id
     *
     * @Route(methods={"GET"}, path="/front/question/{id}", name="front_question_show")
     * @return Response
     */
    public function showAction(EntityManagerInterface $entityManager, Request $request, int $id)
    {
        $questionRepository = $entityManager->getRepository(Question::class);

        $question = $questionRepository->find($id);
        if (null == $question) {
            return new Response('Question does not exist', Response::HTTP_NOT_FOUND);
        }

        $response = $this->render('front/question.html.twig', ['question' => $question]);
        return $response;
    }

    /**
     * @Route(methods={"POST"}, path="/front/question/{id}", name="front_question_post")
     */
    public function postAction()
    {
        return new Response('ummm yeah');
    }
}