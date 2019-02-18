<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\SemesterController;
use AppBundle\Entity\Semester;
use AppBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class SemesterControllerTest extends WebTestCase
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
     * @see SemesterController::indexAction()
     */
    public function testIndexAction()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'admin/semester/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see SemesterController::showAction()
     */
    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();

        /** @var Semester $semester */
        $semester= $this->fixtures->getReference('semester001');

        $client->request('GET', 'admin/semester/'.$semester->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see SemesterController::newAction()
     */
    public function testNewAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_semester[name]' => 'name',
            'app_bundle_semester[enabled]' => false];

        $client->request('POST', 'admin/semester/new', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see SemesterController::editAction()
     */
    public function testEditAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_semester[name]' => 'name',
            'app_bundle_semester[enabled]' => false];

        /** @var Semester $semester */
        $semester= $this->fixtures->getReference('semester001');

        $client->request('POST', 'admin/semester/'.$semester->getId().'/edit', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
