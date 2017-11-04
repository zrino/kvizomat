<?php
namespace CoreBundle\Twig;


use Symfony\Component\Config\Definition\Exception\Exception;

class NoticeExtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('notice', array($this, 'noticeFunction')),
        );
    }

    public function noticeFunction($statusCode)
    {
        switch ($statusCode) {
            case 0:
                $statusClass = 'danger';
                break;
            case 1:
                $statusClass = 'notice';
                break;
            case 2:
                $statusClass = 'success';
                break;
            default:
                throw new Exception("Unknown status code!");
        }

        return $statusClass;
    }
}