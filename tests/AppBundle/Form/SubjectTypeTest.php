<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\Subject;
use AppBundle\Form\SubjectType;

class SubjectTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {

        $formData = array(
            'name' => 'przedmiot',
            'code' => 'uam001',
            'description' => '<p>opis</p>'
        );

        $form = $this->submitAndCheckBasicOptions(SubjectType::class, $formData);
        /** @var Subject $object */
        $object = $this->fromArray($formData, new Subject);
        $this->assertEquals($object->getName(), $form->getData()->getName());
        $this->assertEquals($object->getCode(), $form->getData()->getCode());
        $this->assertEquals($object->getDescription(), $form->getData()->getDescription());
    }
}
