<?php
namespace ProjectBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('label', null,[
                'label'=>'project.label.label',
                'required'=>true,
                'attr'=>['placeholder'=>'project.placeholder.label']
            ])
            ->add('description', null,[
                'label'=>'project.label.description',
                'required'=>false,
                'attr'=>['placeholder'=>'project.placeholder.description']
            ])
            ->add('startDate', DateType::class, [
                'format' => DateType::HTML5_FORMAT,
                'widget' => 'single_text',
                'required' => true,
                'label'=>'project.label.startDate',
                'attr'=>['placeholder'=>'project.placeholder.startDate']
            ])
            ->add('endDate', DateType::class, [
                'format' => DateType::HTML5_FORMAT,
                'widget' => 'single_text',
                'required' => false,
                'label'=>'project.label.endDate',
                'attr'=>['placeholder'=>'project.placeholder.endDate']
            ])
           ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Project'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'projectbundle_project';
    }


}
