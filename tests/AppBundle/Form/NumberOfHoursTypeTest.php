<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\NumberOfHours;
use AppBundle\Form\NumberOfHoursType;
use AppBundle\Form\UserType;

class NumberOfHoursTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {
        $formData = array(
            'lecture' => 40,
            'exercises' => 10,
            'laboratories' => 20,
            'exercisesLaboratories' => 10,
            'ownWork' => 20
        );

        $form = $this->submitAndCheckBasicOptions(NumberOfHoursType::class, $formData);
        /** @var UserType $object */
        $object = $this->fromArray($formData, new NumberOfHours());
        $this->assertEquals($object, $form->getData());
    }
}
