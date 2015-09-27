<?php
namespace PillsBundle\Form;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName', 'text', array('required' => true))

            ->add('email', 'email', array())
//            ->add('country', 'countries', array('label' => 'Countries', 'required' => false, 'mapped' => true,  'attr' => array('placeholder' => 'Select Country')))

            ->add('country', 'entity', array(
                'class' => 'PillsBundle:Country',
                'property' => 'country',
                'attr' => array('placeholder' => 'Select Country'),
                'required' => 'false'
            ))

            ->add('skype', 'text', array('required' => false))
            ->add('telephone', 'text', array('required' => false))
        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User',
           // 'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
