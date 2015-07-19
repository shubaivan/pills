<?php

namespace PillsBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;

class FixturesLoader extends DataFixtureLoader
{
    public function getFixtures()
    {
        return [
            __DIR__ . "/fixtures.yml"
        ];
    }
}
