<?php

namespace ProfileBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use ProfileBundle\Entity\Skill;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadSkillsData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $skill = new Skill();
        $skill->setSkill('Ajax');

        $skill1 = new Skill();
        $skill1->setSkill('Android');

        $skill2 = new Skill();
        $skill2->setSkill('AngularJS');

        $skill3 = new Skill();
        $skill3->setSkill('API');

        $skill4 = new Skill();
        $skill4->setSkill('ASP.NET');

        $skill5 = new Skill();
        $skill5->setSkill('ASP.NET MVC');

        $skill6 = new Skill();
        $skill6->setSkill('Backbone.js');

        $skill7 = new Skill();
        $skill7->setSkill('C');

        $skill8 = new Skill();
        $skill8->setSkill('C#');

        $skill9 = new Skill();
        $skill9->setSkill('C++');

        $skill10 = new Skill();
        $skill10->setSkill('CakePHP');

        $skill11 = new Skill();
        $skill11->setSkill('Clojure');

        $skill12 = new Skill();
        $skill12->setSkill('CMS');

        $skill13 = new Skill();
        $skill13->setSkill('Cocoa');

        $skill14 = new Skill();
        $skill14->setSkill('CoffeeScript');


        $manager->persist($skill);
        $manager->persist($skill1);
        $manager->persist($skill2);
        $manager->persist($skill3);
        $manager->persist($skill4);
        $manager->persist($skill5);
        $manager->persist($skill6);
        $manager->persist($skill7);
        $manager->persist($skill8);
        $manager->persist($skill9);
        $manager->persist($skill10);
        $manager->persist($skill11);
        $manager->persist($skill12);
        $manager->persist($skill13);
        $manager->persist($skill14);

        $manager->flush();
    }

    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}