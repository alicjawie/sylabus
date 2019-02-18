<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\FieldOfStudy;
use AppBundle\Entity\Year;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadYearData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadFieldOfStudyData::ORDER+1;

    public function getModelFile()
    {
        return 'year';
    }

    public function load(ObjectManager $manager)
    {
        $years = $this->getModelFixtures();

        foreach ($years['Year'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['fieldOfStudies'],
                []
            );

            $year = new Year();
            $year->setYear($columns['year']);

            foreach ($columns['fieldOfStudies'] as $fieldOfStudy) {
                /** @var FieldOfStudy $fieldOfStudy */
                $year->addFieldOfStudy($fieldOfStudy);
                $fieldOfStudy->setYear($year);
                $manager->persist($fieldOfStudy);
            }

            $manager->persist($year);

            $this->addReference($key, $year);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
