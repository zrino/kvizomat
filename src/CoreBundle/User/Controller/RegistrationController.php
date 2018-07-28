<?php


namespace CoreBundle\User\Controller;

use CoreBundle\User\Form\UserType;
use CoreBundle\User\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/register", name="user_registration")
     * @param EncoderFactoryInterface $encoderFactory
     * @param Request $request
     * @return Response
     */
    public function registerAction(Request $request, EncoderFactoryInterface $encoderFactory)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $encoder = $encoderFactory->getEncoder($user);
            $salt = $this->createSalt();

            $password = $encoder->encodePassword($user->getPlainPassword(), $salt);
            $user->setPassword($password);

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render(
            'user/register.html.twig',
            array('form' => $form->createView())
        );
    }


    /**
     * Creates and returns unique salt
     * @return string
     */
    private function createSalt()
    {
        return uniqid(mt_rand(), true);
    }
}
?>