<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\DegreeController;
use AppBundle\Entity\Degree;
use AppBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class DegreeControllerTest extends WebTestCase
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
     * @see DegreeController::indexAction()
     */
    public function testIndexAction()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'admin/degree/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see DegreeController::showAction()
     */
    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();

        /** @var Degree $degree */
        $degree= $this->fixtures->getReference('degree-degree001');

        $client->request('GET', 'admin/degree/'.$degree->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see DegreeController::newAction()
     */
    public function testNewAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_degree[name]' => 'name',
            'app_bundle_degree[enabled]' => false];

        $client->request('POST', 'admin/degree/new', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see DegreeController::editAction()
     */
    public function testEditAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_degree[name]' => 'name',
            'app_bundle_degree[enabled]' => false];

        /** @var Degree $degree */
        $degree= $this->fixtures->getReference('degree-degree001');

        $client->request('POST', 'admin/degree/'.$degree->getId().'/edit', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
