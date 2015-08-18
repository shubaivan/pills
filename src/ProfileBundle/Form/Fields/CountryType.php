<?php
namespace ProfileBundle\Form\Fields;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

class CountryType extends AbstractType
{
    private $em;

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }

    public function getCountry()
    {
        $countrys = $this->em->getRepository('PillsBundle:Country')->findAll();
        $new_country = array();

        foreach($countrys as $country) {
            $new_country[$country->getCountry()] = $country->getCountry();
        }

        asort($new_country);

        return $countrys;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'choices' => $this->getCountry(),
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
        return 'country';
    }
}
