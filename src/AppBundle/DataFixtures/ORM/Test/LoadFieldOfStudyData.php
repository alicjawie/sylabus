<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\FieldOfStudy;
use AppBundle\Entity\Semester;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadFieldOfStudyData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadSemesterData::ORDER+1;

    public function getModelFile()
    {
        return 'field_of_study';
    }

    public function load(ObjectManager $manager)
    {
        $fieldOfStudies = $this->getModelFixtures();

        foreach ($fieldOfStudies['FieldOfStudy'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['semesters'],
                []
            );

            $fieldOfStudy = new FieldOfStudy();

            $fieldOfStudy->setMode($columns['mode']);
            $fieldOfStudy->setName($columns['name']);
            $fieldOfStudy->setLanguage($columns['language']);

            foreach ($columns['semesters'] as $semester) {
                /** @var Semester $semester */
                $fieldOfStudy->addSemester($semester);
                $semester->setFieldOfStudy($fieldOfStudy);
                $manager->persist($semester);
            }

            $manager->persist($fieldOfStudy);

            $this->addReference('field-of-'.$key, $fieldOfStudy);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
