<?php
namespace ProfileBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloperType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', null, array('label' => 'First Name', 'max_length' => 255, 'required' => false))
            ->add('lastname', null, array('label' => 'Last Name', 'max_length' => 255, 'required' => false))
            ->add('qualification', 'choice', array('label' => 'Speciality',
                'choices' => array('Frontend' => 'Frontend', 'Backend' => 'Backend', 'Full stack' => 'Full stack'),'attr'=> array('class'=>'qualif'), 'required' => false))
            ->add('level', 'choice', array('label' => 'Professional Level', 'max_length' => 255,
                    'choices' => array('Junior' => 'Junior', 'Middle' => 'Middle', 'Senior' => 'Senior')))
//			->add('main_skill', 'mainSkill', array('label' => 'Main Skill', 'required' => false, 'mapped' => true, 'attr' => array('placeholder' => 'Select your skills ...', 'class'=>'main_skill') ))
            ->add('skills', 'skills', array('label' => 'Professional Skills', 'required' => true, 'mapped' => true, 'attr' => array('placeholder' => 'Select your skills ...')))
//			->add('tags', 'tags', array('label' => 'Tags','required' => false))
            ->add('english', 'choice', array('label' => 'English Level', 'max_length' => 255,
                'choices' => array('Basic' => 'Basic', 'Intermediate' => 'Intermediate', 'Advanced' => 'Advanced')))
            ->add('rate', null, array('label' => 'Rate $/h', 'max_length' => 255, 'required' => false))
            ->add('description', 'textarea', array('label' => 'Profile Summary', 'required' => false))
            ->add('profileSummary', 'textarea', array('label' => 'Profile Summary', 'required' => false))
//            ->add('location', 'entity', array('max_length' => 255, 'class' => 'ArtelCustomerBundle:Cities', 'required' => false))
//			->add('country', 'choice', array('label' => 'Country', 'max_length' => 255, 'required' => false,
//				'choices'   => array('Ukraine' => 'Ukraine', 'Russia' => 'Russia', 'Belarus' => 'Belarus', 'Crimea' => 'Crimea'), 'data' => 'Ukraine'))
            //->add('company', null, array('label' => 'Company', 'max_length' => 255))
            ->add('description', 'textarea', array('label' => 'Comments', 'required' => false))
            ->add('skype', null, array('label' => 'Skype', 'max_length' => 255, 'required' => false))
            ->add('email', null, array('label' => 'Email', 'max_length' => 255, 'required' => false))
            ->add('telephone', null, array('label' => 'Telephone', 'max_length' => 255, 'required' => false))

            ->add('cvUri', null, array('label' => 'CV Upload', 'max_length' => 255))
            ->add('photo', 'text', array('required' => false, 'mapped' => false))
//            ->add('certificates', 'collection', array( 'label' => 'Certificates', 'type'   => 'text',))
//            ->add('workHistory','collection'
//                , array('type' =>  new WorkHistoryType(),'allow_add' => true,
//                                              'prototype' => true,
//                                              'by_reference' => false,))
//            ->add('educations','collection'
//                , array('type' =>  new EducationsType(),'allow_add' => true,
//                    'prototype' => true,
//                    'by_reference' => false,));
//            );
        ;

//        $builder->addEventSubscriber(new UploadFileSubscriber('cvUri', 'uploads/cv/'));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ProfileBundle\Entity\Developer'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'developer';
    }
}
