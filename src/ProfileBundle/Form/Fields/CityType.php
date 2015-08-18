<?php
namespace ProfileBundle\Form\Fields;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class CityType extends AbstractType
{
    private $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCity()
    {
        $citiess = $this->em->getRepository('PillsBundle:Cities')->findAll();
        $new_cities = array();

        foreach($citiess as $citie) {
            $new_cities[$citie->getCity()] = $citie->getCity();
        }

        asort($new_cities);

        return $new_cities;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getCity(),
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
        return 'cities';
    }
}
