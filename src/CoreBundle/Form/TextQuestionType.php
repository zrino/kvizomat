<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use CoreBundle\Form\TextAnswerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use CoreBundle\Entity\Question;
use Doctrine\ORM\EntityRepository;

class TextQuestionType extends AbstractType
{



    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('question',TextType::class)
            ->add('section',ChoiceType::class,array(
                'choices' => $options["created_sections"],
                'label' => 'Section',
                'choice_label' => function($section, $key, $index) {

                    return $section->getName();
                },
            ))
            ->add('answers',CollectionType::class,array("entry_type" => TextAnswerType::class,
                "block_name" => "answers",
                "allow_add" => true,
                "allow_delete" => true,
                "prototype" => true,
                "by_reference" => false,
                "label" => "Answers"))

            ->add('save', SubmitType::class)
        ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Question::class,
            "created_sections" => null,
        ));
    }




}

?>