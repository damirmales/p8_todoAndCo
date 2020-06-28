<?php

namespace Tests\AppBundle\Form;

use AppBundle\Entity\Task;
use AppBundle\Form\TaskType;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Test\TypeTestCase;

class TaskTypeTest extends TypeTestCase
{

    public function testSubmitValidData()
    {
        $formData = [
            'title' => 'title',
            'content' => 'content',
        ];

        $task = new Task();
        // $formData will retrieve data from the form submission; pass it as the second argument
        $form = $this->factory->create(TaskType::class, $task);

        $expected = new Task();
        // ...populate $object properties with the data stored in $formData
        $expected->setTitle($formData['title']);
        $expected->setContent($formData['content']);
        // submit the data to the form directly
        $form->submit($formData);

        // This check ensures there are no transformation failures
        $this->assertTrue($form->isSynchronized());

        // check that $formData was modified as expected when the form was submitted
        $this->assertEquals($expected->getTitle(), $form->getData()->getTitle());
        $this->assertEquals($expected->getContent(), $form->getData()->getContent());
    }
}
