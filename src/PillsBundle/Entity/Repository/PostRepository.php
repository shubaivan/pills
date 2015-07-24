<?php

namespace PillsBundle\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use PillsBundle\Entity\Post;
use PillsBundle\Entity\Tag;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends EntityRepository
{

    public function getPostByTag($tag)
    {
        $date = new \DateTime;

        $qb = $this->getEntityManager()->createQueryBuilder('p');

//        $qb
//            ->select('p')
//            ->from('PillsBundle:Post', 'p')
//            ->getQuery();
//
//        $query = $qb->getQuery();
//        $results = $query->getResult();
//        dump($results);exit;
//        $arrayResults = array();
//
//        foreach ($results as $result) {
//            $result->getTag();
////            dump($result);exit;
//
//                if (is_array($result->getTag())) {
//                    if (count(array_diff($result->getTag(), $tags)) > 0) {
//                        $arrayResults[] = $result;
//                    }
//
//                }
//
//        }

        $qb ->select('p')
            ->from('PillsBundle:Post', 'p')
            ->join('p.tag', 't')
            ->where('t = :tag')
            ->setParameter('tag', $tag)
            ->getQuery();

//        return $arrayResults;
        $query = $qb->getQuery();
        $results = $query->getResult();

        return $results;
    }

    public function getPostByCategory($category)
    {
        $date = new \DateTime;

        $qb = $this->getEntityManager()->createQueryBuilder('p');

        $qb ->select('p')
            ->from('PillsBundle:Post', 'p')
            ->join('p.category', 'c')
            ->where('c = :category')
            ->setParameter('category', $category)
            ->getQuery();

//        return $arrayResults;
        $query = $qb->getQuery();
        $results = $query->getResult();

        return $results;
    }


    public function findDevelopersByFilter($searchParameters)
    {
        $em = $this->getEntityManager();

        $query = $em->createQueryBuilder()
            ->from('ArtelCustomerBundle:Developers','dev')
            ->select('dev as developers, COUNT(dev) as teams,
                      dev.company as company, SUM(dev.active) as active,
                       dev.skills as skill,  COUNT(dev.skills) as numSkills,
                       COUNT(dev.cvUri) as numAttached, MAX(dev.active) as sortActive,
                       MIN(dev.rate) as sortRateMin, MAX(dev.rate) as sortRateMax,
                       dev.email as email
                       ,GROUP_CONCAT(DISTINCT dev.skills, \'\'
                       ORDER by dev.company
                       SEPARATOR \'|\') AS concat');

        if (empty($searchParameters['keywords'])) {

            if (isset($searchParameters[ 'professional_level' ])) foreach ($searchParameters[ 'professional_level' ] as $level) {
                $query->orWhere($query->expr()->like('dev.level', $query->expr()->literal('%' . $level . '%')));
            }

            if (isset($searchParameters[ 'tags' ])) {

                foreach ($searchParameters[ 'tags' ] as $tag) {
                    $query->andWhere($query->expr()->like('dev.tags', $query->expr()->literal('%' . $tag . '";%')));

                }

            }

            if (isset($searchParameters[ 'skills' ])) {

                $ignore_skill = false;
                if (in_array('Not Set', $searchParameters[ 'skills' ]))
                    $ignore_skill = true;

                if (!$ignore_skill) {

                    /* При выборе уровня к примеру middle для java, то должны показывать только middle у которого Java профильная технология */
                    if (isset($searchParameters[ 'professional_level' ]) && sizeof($searchParameters[ 'professional_level' ]) == 1) {

                        if ($searchParameters[ 'skills' ] != array() && $searchParameters[ 'skills' ]) {
                            $query->andWhere($query->expr()->in('dev.main_skill', $searchParameters[ 'skills' ]));
                        }

                    } else {

                        foreach ($searchParameters[ 'skills' ] as $skill) {
                            if ($skill) $query->andWhere($query->expr()->like('dev.skills', $query->expr()->literal('%' . $skill . '";%')) . " OR dev.main_skill = " . $query->expr()->literal($skill));

                        }

                    }

                }

            }

            if (isset($searchParameters[ 'english' ])) {

                if ($searchParameters[ 'english' ] != array()) {

                    $ignore_english = false;
                    if (in_array('Not Set', $searchParameters[ 'english' ]))
                        $ignore_english = true;

                    if (!$ignore_english)
                        $query->andWhere($query->expr()->in('dev.english', $searchParameters[ 'english' ]));
                }
            }

            if (isset($searchParameters[ 'availability' ])) {
                if ($searchParameters[ 'availability' ] == 'Potentially Available') {
                    $query->andWhere('dev.active = 0');
                } elseif ($searchParameters[ 'availability' ] == 'Available Now') {
                    $query->andWhere('dev.active = 1');
                }
            }

            if (isset($searchParameters[ 'country' ])) {
                $query->andWhere('dev.country = :country')->setParameter('country', $searchParameters[ 'country' ]);
            }

            if (isset($searchParameters[ 'location' ])) if ($searchParameters[ 'location' ] != 'Any') $query->andWhere($query->expr()->like('dev.location', $query->expr()->literal('%' . $searchParameters[ 'location' ] . '%')));

            if (isset($searchParameters[ 'rate' ])) if ($searchParameters[ 'rate' ] != 'Any') {
                $rate = substr($searchParameters[ 'rate' ], 1, 2);
                $query->andWhere('dev.rate < :rate')->setParameter('rate', $rate);
            }
            if (isset($searchParameters[ 'company' ])) {
                if ($searchParameters[ 'company' ] != 'All') {
                    $query->andWhere($query->expr()->like('dev.email', $query->expr()->literal('%' . $searchParameters[ 'company' ] . '%')));
                }
            }

            if (isset($searchParameters[ 'CVSort' ])) {
                if ($searchParameters[ 'CVSort' ] == 'Attached') $query->andWhere('dev.cvUri IS NOT NULL');

            }
            if (!empty($searchParameters[ 'no_tags' ])) {

                $except_ids = [];
                foreach ($searchParameters[ 'no_tags' ] as $tag) {

                    $em = $this->getEntityManager();

                    $q = $em->createQuery("SELECT n.id FROM ArtelCustomerBundle:Developers n WHERE n.tags LIKE :tag")->setParameter('tag', '%' . $tag . '%');

                    $entities = $q->getArrayResult();

                    foreach ($entities as $data)
                        array_push($except_ids,$data['id']);
                }

                $query->andWhere($query->expr()->notIn('dev.id', $except_ids));
            }
        }

        if (isset($searchParameters[ 'company' ])) {
            if ($searchParameters[ 'company' ] == 'All') {
                $query->groupBy('dev.email');
            } else {
                $query->groupBy('dev.id');
            }
        }

        if (isset($searchParameters[ 'developers' ])) {
            if ($searchParameters[ 'developers' ] == 'Individuals') {
                $query->andHaving('teams < 2');
            }
            if ($searchParameters[ 'developers' ] == 'Teams' && $searchParameters[ 'company' ] == 'All') {
                $query->andHaving('teams > 1');
            }

        }

        $query->addOrderBy('sortActive', 'DESC');

        if (isset($searchParameters[ 'rateSort' ])) if ($searchParameters[ 'rateSort' ] == 'Highest Rate') {
            $query->addOrderBy('sortRateMax', 'DESC');
        } elseif ($searchParameters[ 'rateSort' ] == 'Lowest Rate') {
            $query->addOrderBy('sortRateMin', 'ASC');
        }

        if (!empty($searchParameters['keywords'])) {

            if (isset($searchParameters[ 'company' ])) {
                if ($searchParameters[ 'company' ] != 'All') {
                    $query->where($query->expr()->like('dev.email', $query->expr()->literal('%' . $searchParameters[ 'company' ] . '%')));
                }
            }

            $keywords = [];
            if (strpos($searchParameters['keywords'],',') !== false) {
                $keywords = array_map('trim', explode(',', $searchParameters['keywords']));
            } else
                $keywords[] = $searchParameters['keywords'];

            foreach ($keywords as $keyword) {
                $query->andWhere($query->expr()->like('dev.skills', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.main_skill', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.firstName', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.lastName', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.email', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.skype', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.telephone', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.description', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.qualification', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.profileSummary', $query->expr()->literal('%' . $keyword . '%')) .
                    ' OR '. $query->expr()->like('dev.company', $query->expr()->literal('%' . $keyword . '%'))
                );

            }
        }
        //print_r((string)$query);die;
        return $query;
    }

}
