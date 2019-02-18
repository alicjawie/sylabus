<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\SubjectController;
use AppBundle\Entity\Subject;
use AppBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class SubjectControllerTest extends WebTestCase
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
     * @see SubjectController::indexAction()
     */
    public function testIndexAction()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'admin/subject/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see SubjectController::showAction()
     */
    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();

        /** @var Subject $subject */
        $subject= $this->fixtures->getReference('subject001');

        $client->request('GET', 'admin/subject/'.$subject->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see SubjectController::newAction()
     */
    public function testNewAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_degree[name]' => 'name',
            'app_bundle_degree[enabled]' => false];

        $client->request('POST', 'admin/subject/new', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see SubjectController::editAction()
     */
    public function testEditAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_degree[name]' => 'name',
            'app_bundle_degree[enabled]' => false];

        /** @var Subject $subject */
        $subject= $this->fixtures->getReference('subject001');

        $client->request('POST', 'admin/subject/'.$subject->getId().'/edit', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
