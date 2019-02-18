<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\NumberOfHours;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadNumberOfHoursData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = 1;

    public function getModelFile()
    {
        return 'number_of_hours';
    }

    public function load(ObjectManager $manager)
    {
        $numberOfHours = $this->getModelFixtures();

        foreach ($numberOfHours['NumberOfHours'] as $key => $columns) {
            $numberOfHours = new NumberOfHours();

            $numberOfHours->setLecture($columns['lecture']);
            $numberOfHours->setExercises($columns['exercises']);
            $numberOfHours->setLaboratories($columns['laboratories']);
            $numberOfHours->setExercisesLaboratories($columns['exercisesLaboratories']);
            $numberOfHours->setOwnWork($columns['ownWork']);

            $numberOfHours->countHours();

            $manager->persist($numberOfHours);

            $this->addReference('number-of-'.$key, $numberOfHours);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
