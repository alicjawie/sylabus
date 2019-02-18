<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\Semester;
use AppBundle\Entity\Subject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadSemesterData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadSubjectData::ORDER+1;

    public function getModelFile()
    {
        return 'semester';
    }

    public function load(ObjectManager $manager)
    {
        $semesters = $this->getModelFixtures();

        foreach ($semesters['Semester'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['subjects'],
                []
            );

            $type = ($columns['type'] === 'winter')?Semester::WINTER_TYPE:Semester::SUMMER_TYPE;
//            $fieldOfStudyType = $columns['fieldOfStudyType'];

            $semester = new Semester(
                true,
                $columns['yearOfStudy'],
                $type
            );

            foreach ($columns['subjects'] as $subject) {
                /** @var Subject $subject */
                $semester->addSubject($subject);
            }

            $manager->persist($semester);

            $this->addReference($key, $semester);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
