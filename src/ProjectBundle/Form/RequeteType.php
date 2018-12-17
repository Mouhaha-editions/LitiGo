<?php

namespace ProjectBundle\Form;

use ProjectBundle\Entity\Requete;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class RequeteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('label', null, [
                'label' => 'request.label.label',
                'required' => true,
                'attr' => ['placeholder' => 'request.placeholder.label']
            ])
            ->add('description', null, [
                'label' => 'request.label.description',
                'required' => false,
                'attr' => ['placeholder' => 'request.placeholder.description', 'class'=>'trumb']
            ])
            ->add('type', ChoiceType::class, [
                'choices' => [
                    "Bug" => Requete::TYPE_BUG,
                    "Nouvelle demande" => Requete::TYPE_NEW,
                    "Idée" => Requete::TYPE_IDEA,
                ],
                'label' => 'request.label.type',
                'required' => true,
                'attr' => ['placeholder' => 'request.placeholder.type']
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProjectBundle\Entity\Requete'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'projectbundle_request';
    }


}
