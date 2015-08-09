<?php
namespace ProfileBundle\Form\Fields;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class TagsType extends AbstractType
{
    private $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getTags()
    {
        $tags = $this->em->getRepository('ArtelCustomerBundle:Tags')->findAll();
        $new_tags = array();

        foreach($tags as $tag)
            $new_tags[$tag->getTag()] = $tag->getTag();

        return $new_tags;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getTags(),
            'multiple' => true,
            'required' => false,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'tags';
    }
}
