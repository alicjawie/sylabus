<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\Degree;
use AppBundle\Form\DegreeType;

class DegreeTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {
        $formData = array(
            'name' => 'Licencjat',
            'enabled' => true
        );

        $form = $this->submitAndCheckBasicOptions(DegreeType::class, $formData);
        /** @var Degree $object */
        $object = $this->fromArray($formData, new Degree());
        $this->assertEquals($object->getName(), $form->getData()->getName());
        $this->assertEquals($object->getEnabled(), $form->getData()->getEnabled());
    }
}
