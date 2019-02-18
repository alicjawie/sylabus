<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\AdditionalField;
use AppBundle\Form\AdditionalFieldType;

class AdditionalFieldTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {
        $formData = array(
            'ECTS' => 20,
            'exam' => true
        );

        $form = $this->submitAndCheckBasicOptions(AdditionalFieldType::class, $formData);
        /** @var AdditionalField $object */
        $object = $this->fromArray($formData, new AdditionalField());
        $this->assertEquals($object->getECTS(), $form->getData()->getECTS());
        $this->assertEquals($object->getExam(), $form->getData()->getExam());
    }
}
