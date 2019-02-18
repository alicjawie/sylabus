<?php

namespace AppBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;

abstract class AbstractYamlFixture extends AbstractFixture
{
    use \AppBundle\Utils\YamlLoaderTrait;
    
    public function getFixturesPath()
    {
        return realpath(dirname(__FILE__).'/../Fixtures');
    }

    /**
     * @param array $fixtures single fixture array from yaml
     * @param array $references references of object to replace
     * @param array $dateTimes string with date time to convert to \DateTime
     * @return array
     */
    protected function convertReferences(array $fixtures, array $references, array $dateTimes)
    {
        foreach ($references as $reference) {
            if ($fixtures[$reference]) {
                $fixtures[$reference] = $this->handleReference($fixtures[$reference]);
            }
        }
        foreach ($dateTimes as $dateTime) {
            if ($fixtures[$dateTime]) {
                $fixtures[$dateTime] = new \DateTime($fixtures[$dateTime]);
            }
        }

        return $fixtures;
    }

    private function handleReference($reference)
    {
        $entities = [];
        if (is_array($reference)) {
            foreach ($reference as $singleReference) {
                $entities[] = $this->getReference($singleReference);
            }

            return $entities;
        } else {
            return $this->getReference($reference);
        }
    }
}
