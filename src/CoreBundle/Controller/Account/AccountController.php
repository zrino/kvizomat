<?php

namespace CoreBundle\Controller\Account;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CoreBundle\Entity\User;


class AccountController extends Controller
{

    /**
     * @Route("/myaccount",name="myaccount")
     */
    public function myaccountAction(Request $request,$quiz_id=0,$question_id=0)
    {
        #TODO authentication
        $repo = $this->getDoctrine()->getRepository(User::class);
        $user = $repo->findOneBy(array("id" => $this->getUser()));

        return $this->render("myaccount/myaccount.html.twig", array("user" => $user));
    }
}

?>