<?php
namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use AppBundle\Form\TextAnswerType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Section;
use Doctrine\ORM\EntityRepository;

class SectionType extends AbstractType
{



    public function __construct()
    {

    }

    public function buildForm(FormBuilderInterface $builder,array $options)
    {
        $builder
            ->add('name',TextType::class)
            ->add('section_text',TextareaType::class,array(
                'label' => 'Text (optional)',
                'required' => false,
            ))
            ->add('save', SubmitType::class)
        ;

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Section::class
        ));
    }




}

?>