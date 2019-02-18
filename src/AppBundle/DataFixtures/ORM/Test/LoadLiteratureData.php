<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\CourseContent;
use AppBundle\Entity\ExtraField;
use AppBundle\Entity\Subject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadLiteratureData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadSubjectData::ORDER+1;

    public function getModelFile()
    {
        return 'literature';
    }

    public function load(ObjectManager $manager)
    {
        $subjects = $this->getModelFixtures();

        foreach ($subjects['Literature'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['subject'],
                []
            );

            /** @var Subject $subject */
            $subject = $columns['subject'];

            $literature = new CourseContent();
            $literature->setDescription($columns['description']);
            $literature->setTitle($columns['title']);
            $literature->setAuthor($columns['author']);
            $literature->setSubject($subject);

            $subject->addCourseContent($literature);

            $manager->persist($literature);
            $manager->persist($subject);

            $this->addReference($key, $literature);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
