<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\Subject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSubjectData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadNumberOfHoursData::ORDER+1;

    public function getModelFile()
    {
        return 'subject';
    }

    public function load(ObjectManager $manager)
    {
        $subjects = $this->getModelFixtures();

        foreach ($subjects['Subject'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['numberOfHours','additionalField'],
                []
            );

            $subject = new Subject(
                true,
                $columns['name'],
                $columns['description'],
                $columns['numberOfHours'],
                $columns['additionalField'],
                $columns['code'],
                $columns['lecturer']
            );

            $manager->persist($subject);

            $this->addReference($key, $subject);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
