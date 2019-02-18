<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\User;
use AppBundle\Form\UserType;

class UserTypeTest extends AbstractFormTypeTest
{
    public function testSubmitValidData()
    {
        $formData = array(
            'username' => 'test',
            'name' => 'test',
            'surname' => 'test',
            'index' => 's69',
            'email' => 'test@test.com'
        );

        $form = $this->submitAndCheckBasicOptions(UserType::class, $formData);
        /** @var UserType $object */
        $object = $this->fromArray($formData, new User());
        $this->assertEquals($object, $form->getData());
    }
}
