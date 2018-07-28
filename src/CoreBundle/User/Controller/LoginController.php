<?php

namespace CoreBundle\User\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class LoginController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     * @param Request $request
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function indexAction(
        Request $request,
        AuthenticationUtils $authenticationUtils
    )
    {
        if (null != $this->getUser()) {
            return new Response('You are already logged in');
        }
       $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'lastUsername' => $lastUsername,
            'error' => $error
        ]);


    }
}

?>