<?php

namespace PillsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PillsBundle\Entity\Category;
use PillsBundle\Entity\Tag;

class PostType extends AbstractType
{
    public $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tag = $this->tags;
//        $em = $this->getDoctrine()->getManager();
//        $repo = $em->getRepository('LebedVideoBundle:Category');
//        $categories = $repo->childrenHierarchy();

        $builder

            ->add('title', 'text')
            ->add('description', 'textarea')
            ->add('photo', 'file')

            ->add('country', 'entity', array(
                'class' => 'PillsBundle:Country',
                'property' => 'country',
                'required' => 'false'
            ))
            ->add('city', 'entity', array(
                'class' => 'PillsBundle:Cities',
                'property' => 'city',
                'required' => 'false'
            ))

            ->add('type', 'entity', array(
                'class' => 'PillsBundle:Type',
                'property' => 'name',
                'required' => 'false'
            ))
            ->add('category', 'entity', array(
                'class' => 'PillsBundle:Category',
                'property' => 'title',
                'required' => 'false'
            ))

            ->add('tag', 'entity', [
                'class' => 'PillsBundle:Tag',
                'choices' => new GetTagType($tag),
                'multiple' => true
            ])
            ->add('save', 'submit')
            ->getForm();
    }

    public function getName()
    {
        return 'video';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PillsBundle\Entity\Post',
        ));
    }
}

