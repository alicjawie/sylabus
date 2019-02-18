<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\AdditionalField;
use AppBundle\Entity\Degree;
use AppBundle\Entity\FieldOfStudy;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDegreeData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadFieldOfStudyData::ORDER+1;

    public function getModelFile()
    {
        return 'degree';
    }

    public function load(ObjectManager $manager)
    {
        $fieldOfStudies = $this->getModelFixtures();

        foreach ($fieldOfStudies['Degree'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['fieldOfStudies'],
                []
            );

            $degree = new Degree();

            $degree->setName($columns['name']);

            foreach ($columns['fieldOfStudies'] as $fieldOfStudy) {
                /** @var FieldOfStudy $fieldOfStudy */
                $degree->addFieldOfStudy($fieldOfStudy);
                $fieldOfStudy->setDegree($degree);
                $manager->persist($fieldOfStudy);
            }

            $manager->persist($degree);

            $this->addReference('degree-'.$key, $degree);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
