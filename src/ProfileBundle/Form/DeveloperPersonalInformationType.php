<?php
namespace ProfileBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloperPersonalInformationType extends AbstractType
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
            ->add('email', null, array('label' => 'Email', 'max_length' => 255, 'required' => false));

                $builder
                    ->add('country', 'entity', array(
                        'class' => 'PillsBundle:Country',
//                        'choice_label' => 'Select Country',
                    ));

                $builder
                    ->add('city', 'entity', array(
                        'class' => 'PillsBundle:Cities',
        //                        'choice_label' => 'Select Country',
                    ));
        $builder
            ->add('skype', null, array('label' => 'Skype', 'max_length' => 255, 'required' => false))
            ->add('telephone', null, array('label' => 'Phone', 'max_length' => 255, 'required' => false, 'attr' => array('data-inputmask' => "'alias': 'date'")))
            ->add('save', 'submit');
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
            'validation_groups' => array('personal_information')
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'developer_personal_information';
    }
}
