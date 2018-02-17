<?php
namespace CoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

abstract class BaseController extends Controller
{
    const WARNING_CODE = 0;
    const NOTICE_CODE = 1;
    const SUCCESS_CODE = 2;

    protected function concatErrors(ConstraintViolationListInterface $e)
    {
        $errorStr = "";
        foreach($e as $error) {
            $errorStr .= $error->getMessage() . PHP_EOL;
        }
        return $errorStr;
    }

    public function error404()
    {
        return new Response("You're not allowed to do that!");
    }

}