<?php
namespace ProfileBundle\Form\Fields;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class MainSkillType extends AbstractType
{
    private $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getSkills()
    {
        $skills = $this->em->getRepository('ProfileBundle:Skill')->findAll();
        $new_skills = array();

        foreach($skills as $skill)
            $new_skills[$skill->getSkill()] = $skill->getSkill();

        return $new_skills;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getSkills(),
            'multiple' => false,
            'required' => false,
        ));
    }

    public function getParent()
    {
        return 'choice';
    }

    public function getName()
    {
        return 'mainSkill';
    }
}
