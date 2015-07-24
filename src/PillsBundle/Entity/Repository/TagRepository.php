<?php

namespace PillsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * TagRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class TagRepository extends EntityRepository
{

    public function findTopTags()
    {
        $tags = $this->getEntityManager()->getRepository('PillsBundle:Tag')
            ->createQueryBuilder('t')
            ->groupBy('t.hashTag')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();

        usort($tags, function ($a, $b) {
            if (COUNT($a->getPost()) == COUNT($b->getPost())) {
                return 0;
            }

            return (COUNT($a->getPost()) > COUNT($b->getPost())) ? -1 : 1;
        });

        return $tags;
    }

}