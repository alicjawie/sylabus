<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\ExtraField;
use AppBundle\Entity\Subject;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadCourseContentData extends AbstractYamlFixture implements OrderedFixtureInterface
{
    const ORDER = LoadSubjectData::ORDER+1;

    public function getModelFile()
    {
        return 'course_content';
    }

    public function load(ObjectManager $manager)
    {
        $subjects = $this->getModelFixtures();

        foreach ($subjects['Course'] as $key => $columns) {
            $columns = $this->convertReferences(
                $columns,
                ['subject'],
                []
            );

            /** @var Subject $subject */
            $subject = $columns['subject'];

            $course = new ExtraField();
            $course->setDescription($columns['description']);
            $course->setTitle($columns['title']);
            $course->setSubject($subject);

            $subject->addExtraField($course);

            $manager->persist($course);
            $manager->persist($subject);

            $this->addReference('course-'.$key, $course);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
