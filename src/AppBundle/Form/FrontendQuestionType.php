<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\TextAnswerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Question;
use Doctrine\ORM\EntityRepository;

class FrontendQuestionType extends AbstractType
{



    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('answers',CollectionType::class,array("entry_type" => CheckboxType::class,
                "block_name" => "answers",
                "by_reference" => false,
                "label" => "Answers"))

            ->add('save', SubmitType::class)
        ;

    }





}

?>