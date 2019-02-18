<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\AdditionalField;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadAdditionalFieldData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = 1;

    public function getModelFile()
    {
        return 'additional_field';
    }

    public function load(ObjectManager $manager)
    {
        $additionalFields = $this->getModelFixtures();

        foreach ($additionalFields['AdditionalField'] as $key => $columns) {
            $additionalField = new AdditionalField();
            $additionalField->setECTS($columns['ECTS']);
            $additionalField->setExam($columns['exam']);

            $manager->persist($additionalField);
            $this->addReference('additional-'.$key, $additionalField);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
