<?php

namespace AppBundle\Tests\Controller;

use AppBundle\Controller\UserController;
use AppBundle\Entity\User;
use AppBundle\Test\WebTestCase;
use Doctrine\Common\DataFixtures\ReferenceRepository;

class UserControllerTest extends WebTestCase
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
     * @see UserController::indexAction()
     */
    public function testIndexAction()
    {
        $client = $this->createAuthenticatedClient();

        $client->request('GET', 'admin/user/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see UserController::showAction()
     */
    public function testShowAction()
    {
        $client = $this->createAuthenticatedClient();

        /** @var User $user */
        $user= $this->fixtures->getReference('user-user');

        $client->request('GET', 'admin/user/'.$user->getId());
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see UserController::newAction()
     */
    public function testNewAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_user[name]' => 'name',
            'app_bundle_user[enabled]' => false];

        $client->request('POST', 'admin/user/new', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * @see UserController::editAction()
     */
    public function testEditAction()
    {
        $client = $this->createAuthenticatedClient();

        $form = [
            'app_bundle_user[name]' => 'name',
            'app_bundle_user[enabled]' => false];

        /** @var User $user */
        $user= $this->fixtures->getReference('user-user');

        $client->request('POST', 'admin/user/'.$user->getId().'/edit', [], [], ['CONTENT_TYPE' => 'text/html'],
            $form);

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}
