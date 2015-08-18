<?php
namespace PillsBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use PillsBundle\Entity\Tag;

class GetTagType extends AbstractType
{
    public $tags;

    public function __construct(array $tags)
    {
        $this->tags = $tags;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $tags = [];
        foreach ($this->tags->getTag() as $key => $value) {
            $tags[$value->getId()] = $value->getHashTag();
        }

        $builder
            ->add('hashTag', 'choice', [
                'choices' => $tags
            ]);
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PillsBundle\Entity\Tag',
        ));
    }

    public function getName()
    {
        return 'getTag';
    }
}
