<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\FieldOfStudyController;
use AppBundle\Entity\FieldOfStudy;
use AppBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class FieldOfStudyControllerTest extends WebTestCase
{

    /**
     * @var ReferenceRepository
     */
    private $fixtures;

    protected function setUp()
    {
        $this->fixtures = $this->loadFixtures(self::FIXTURES)->getReferenceRepository();
    }

    /**
     * @see FieldOfStudyController::indexAction()
     */
    public function testIndexAction()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'admin/field-of-study/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see FieldOfStudyController::showAction()
     */
    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();

        /** @var FieldOfStudy $fieldOFStudy */
        $fieldOFStudy= $this->fixtures->getReference('field-of-study001');

        $client->request('GET', 'admin/field-of-study/'.$fieldOFStudy->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see FieldOfStudyController::newAction()
     */
    public function testNewAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_degree[name]' => 'name',
            'app_bundle_degree[enabled]' => false];

        $client->request('POST', 'admin/field-of-study/new', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see FieldOfStudyController::editAction()
     */
    public function testEditAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_degree[name]' => 'name',
            'app_bundle_degree[enabled]' => false];

        /** @var FieldOfStudy $fieldOFStudy */
        $fieldOFStudy= $this->fixtures->getReference('field-of-study001');

        $client->request('POST', 'admin/field-of-study/'.$fieldOFStudy->getId().'/edit', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
