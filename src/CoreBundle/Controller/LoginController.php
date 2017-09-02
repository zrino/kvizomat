<?php

namespace CoreBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class LoginController extends Controller
{

    /**
     * @Route("/quiz/addquestion/{page}",name="add_question", requirements={"page": "\d+"})
     */
    public function indexAction()
    {

        $form = new LoginForm();

        return $this->render('default/login.html.twig', array('form' => $form->createView()));


    }
}

?>