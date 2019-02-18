<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\ExtraField;
use AppBundle\Form\ExtraFieldType;

class ExtraFieldTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {
        $formData = array(
            'title' => 'Dziady',
            'description' => 'Opowiada o dziadach',
        );

        $form = $this->submitAndCheckBasicOptions(ExtraFieldType::class, $formData);
        $object = $this->fromArray($formData, new ExtraField());
        $this->assertEquals($object, $form->getData());
    }
}
