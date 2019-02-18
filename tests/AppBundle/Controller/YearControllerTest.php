<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\YearController;
use AppBundle\Entity\Year;
use AppBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class YearControllerTest extends WebTestCase
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
     * @see YearController::indexAction()
     */
    public function testIndexAction()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'admin/year/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see YearController::showAction()
     */
    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();

        /** @var Year $year */
        $year= $this->fixtures->getReference('year001');

        $client->request('GET', 'admin/year/'.$year->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see YearController::newAction()
     */
    public function testNewAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_year[name]' => 'name',
            'app_bundle_year[enabled]' => false];

        $client->request('POST', 'admin/year/new', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see YearController::editAction()
     */
    public function testEditAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_year[name]' => 'name',
            'app_bundle_year[enabled]' => false];

        /** @var Year $year */
        $year= $this->fixtures->getReference('year001');

        $client->request('POST', 'admin/year/'.$year->getId().'/edit', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
