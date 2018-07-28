<?php

namespace CoreBundle\User\Controller;

use CoreBundle\User\Entity\User;
use CoreBundle\User\Form\UserType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends Controller
{
    /**
     * @Security("has_role('ROLE_USER')")
     * @Route("/user/profile", name="user_profile")
     * @param Request $request
     * @return Response
     */
    public function profileAction(Request $request)
    {
        /**
         * @var User $user
         */
        $user = $this->getUser();
        if (null == $user) {
            return new RedirectResponse('/login');
        }

        $form = $this->createForm(UserType::class, $user);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $user->setUsername($data['username']);
            $user->setEmail($data['email']);
        }

        return $this->render('user/profile.html.twig', ['form' => $form->createView()]);
    }
}