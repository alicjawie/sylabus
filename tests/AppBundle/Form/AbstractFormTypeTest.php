<?php

namespace Tests\AppBundle\Form;

use Symfony\Component\Form\Test\TypeTestCase;

abstract class AbstractFormTypeTest extends TypeTestCase
{
    use FromArrayTrait;

    public function submitAndCheckBasicOptions($class, $formData)
    {
        $form = $this->factory->create($class);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());

        $view = $form->createView();
        $children = $view->children;

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $children);
        }

        return $form;
    }
}