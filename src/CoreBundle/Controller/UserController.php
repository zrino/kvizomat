<?php

namespace CoreBundle\Controller;

use CoreBundle\Form\UserForm;
use CoreBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use CoreBundle\Form\UserLoginForm;
use Symfony\Component\Config\Definition\Exception\Exception;

class UserController extends BaseController
{
    /**
     * @Route("/register", name="register")
     * @param Request $request
     * @return null|\Symfony\Component\HttpFoundation\Response
     */
    public function registerAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserForm::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')
                ->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->get('security.authentication.guard_handler')->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $this->get('core.security.login_authenticator'),
                'main'
            );
        }

        return $this->render(
            'registration/register.html.twig',
            array('form' => $form->createView())
        );
    }

    /**
     * @Route("/login", name="login")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function loginAction(Request $request)
    {
        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        $form = $this->createForm(UserLoginForm::class, [
            'username' => $lastUsername
        ]);

        return $this->render('security/login.html.twig', array(
            'form' => $form->createView(),
            'error' => $error,
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {
        throw new Exception("Should be unreachable");
    }


    /**
     * @Route("/profile", name="profile")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function profileAction(Request $request)
    {
        $encoder = $this->get('security.password_encoder');

        $validator = $this->get('validator');

        $em = $this->get('doctrine.orm.entity_manager');

        $user = $this->getUser();
        $username = $user->getUsername();
        $email = $user->getEmail();

        if (true === $request->isMethod("POST")) {
            $username = $request->request->get('_username');
            $email = $request->request->get("_email");
            $oldPassword = $request->request->get('_old_password');
            $newPassword = $request->request->get('_new_password');
            $newPassword2 = $request->request->get('_new_password_2');

            if (false === $encoder->isPasswordValid($user, $oldPassword) || $newPassword2 !== $newPassword) {
                $this->get('session')->getFlashBag()->add(
                    'changeProfileNotice',
                    [$this::WARNING_CODE, 'Password not correct']
                );
                return $this->redirectToRoute("profile");
            }

            $user->setUsername($username);
            $user->setEmail($email);
            $user->setPlainPassword($newPassword);

            $errors = $validator->validate($user);
            if (0 == count($errors)) {
                $em->persist($user);
                $em->flush();

                $this->get('session')->getFlashBag()->add(
                    'changeProfileNotice',
                    [$this::SUCCESS_CODE, 'Succesfully changed profile info']
                );
                return $this->redirectToRoute("profile");
            }

            $this->get('session')->getFlashBag()->add(
                'changeProfileNotice',
                [$this::WARNING_CODE, $this->concatErrors($errors)]
            );
        }

        return $this->render('user/userprofile.html.twig', [
           "username" => $username,
            "email" => $email
        ]);
    }
}
?>