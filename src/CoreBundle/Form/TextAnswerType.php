<?php
namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use CoreBundle\Entity\TextAnswer;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TextAnswerType extends AbstractType
{
    private $answer;

    private $correctAns;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('answer',TextType::class,array("label" => false,"block_name" => "answer"))
            ->add('isCorrect',CheckboxType::class,
                array("label" => "Correct",
                        'required' => false,))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => TextAnswer::class,
        ));
    }
}

?>