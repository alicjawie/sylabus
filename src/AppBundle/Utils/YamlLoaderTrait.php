<?php

namespace AppBundle\Utils;

use Symfony\Component\Yaml\Yaml;

trait YamlLoaderTrait
{
    abstract public function getModelFile();

    abstract public function getFixturesPath();

    /**
     * Return the fixtures for the current model.
     *
     * @return array
     */
    public function getModelFixtures()
    {
        $fixturesPath = $this->getFixturesPath();
        $fixtures = Yaml::parse(file_get_contents($fixturesPath.'/'.$this->getModelFile().'.yml'));

        return $fixtures;
    }
}
