<?php
namespace CoreBundle\Security;

use CoreBundle\Form\UserLoginForm;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Router;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoder;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Guard\AbstractGuardAuthenticator;
use Symfony\Component\Security\Core\Security;

class LoginAuthenticator extends AbstractGuardAuthenticator
{
    private $formFactory;
    private $em;
    private $passworEncoder;
    private $router;

    public function __construct(FormFactoryInterface $formFactory, EntityManager $em, UserPasswordEncoder $encoder, Router $router)
    {
        $this->formFactory = $formFactory;
        $this->em = $em;
        $this->passworEncoder = $encoder;
        $this->router = $router;
    }

    public function getCredentials(Request $request)
    {
        $isLoginSubmit = $request->getPathInfo() == '/login' && $request->isMethod('POST');
        if (!$isLoginSubmit) {
            return ;
        };

        $form = $this->formFactory->create(UserLoginForm::class);
        $form->handleRequest($request);
        if($form->isValid());
        $data = $form->getData();

        return $data;
    }

    public function getUser($credentials, UserProviderInterface $user)
    {
        $username = $credentials['username'];

        return $this->em->getRepository('CoreBundle:User')->findOneBy(['username' => $username]);
    }

    public function checkCredentials($credentials, UserInterface $user)
    {
        if(!$this->passworEncoder->isPasswordValid($user, $credentials["password"])) {
            return false;
        }
        return true;
    }

    public function start(Request $request, AuthenticationException $authException = null)
    {
        $data = array(
            'message' => 'Authentication Required'
        );
        return new RedirectResponse($this->router->generate("login"));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        return new RedirectResponse($this->router->generate("login"));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, $providerKey)
    {
        return new RedirectResponse($this->router->generate("homepage"));
    }

    public function supportsRememberMe()
    {
        // TODO: Implement supportsRememberMe() method.
    }
}