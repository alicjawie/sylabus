<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\Year;
use AppBundle\Form\YearType;

class YearTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {
        $formData = array(
            'year' => '2022/2023'
        );

        $form = $this->submitAndCheckBasicOptions(YearType::class, $formData);
        /** @var YearType $object */
        $object = $this->fromArray($formData, new Year());
        $this->assertEquals($object, $form->getData());
    }
}
