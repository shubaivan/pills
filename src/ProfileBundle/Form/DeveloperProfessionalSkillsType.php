<?php
namespace ProfileBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloperProfessionalSkillsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('level', 'choice', array('label' => 'Speciality', 'max_length' => 255,
                'choices' => array('Junior' => 'Junior', 'Middle' => 'Middle', 'Senior' => 'Senior')))
            ->add('qualification', 'choice', array('label' => 'Speciality',
                'choices' => array('Frontend' => 'Frontend', 'Backend' => 'Backend', 'Full stack' => 'Full stack'),'attr'=> array('class'=>'qualif'), 'required' => true))
            ->add('main_skill', 'mainSkill', array('label' => 'Main Skill', 'required' => false, 'mapped' => true, 'attr' => array('placeholder' => 'Select...', 'class'=>'main_skill') ))
            ->add('skills', 'skills', array('label' => 'Professional Skills', 'required' => true, 'mapped' => true,  'attr' => array('placeholder' => 'Select Skills')))
//			->add('tags', 'tags', array('label' => 'Tags','required' => false))
            ->add('english', 'choice', array('label' => 'English Level', 'max_length' => 255,
                'choices' => array('Basic' => 'Basic', 'Intermediate' => 'Intermediate', 'Advanced' => 'Advanced')))
            ->add('rate', 'text', array('label' => 'Rate $/h', 'max_length' => 255, 'required' => false))
            ->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
            'validation_groups' => array('professional_skills')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'developer_professional_skills';
    }
}
