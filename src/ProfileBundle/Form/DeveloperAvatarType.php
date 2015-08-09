<?php
namespace ProfileBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DeveloperAvatarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', 'file', array(
                'label' => 'avatar',
            ))
            ->add('save', 'submit');
    }

//    public function setDefaultOptions(OptionsResolverInterface $resolver)
//    {
//        $resolver->setDefaults(array(
//            'data_class' => 'ProfileBundle\Entity\Photo',
//        ));
//    }

    public function getName()
    {
        return 'photo';
    }
}
