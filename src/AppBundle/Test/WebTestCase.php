<?php

namespace AppBundle\Test;

use AppBundle\Entity\User;
use Liip\FunctionalTestBundle\Test\WebTestCase as BaseWebTestCase;
use Symfony\Component\BrowserKit\Cookie;

class WebTestCase extends BaseWebTestCase
{
    const FIXTURES = [
        \AppBundle\DataFixtures\ORM\Test\LoadAdditionalFieldData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadDegreeData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadFieldOfStudyData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadNumberOfHoursData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadSemesterData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadSubjectData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadUserData::class,
        \AppBundle\DataFixtures\ORM\Test\LoadYearData::class,
    ];

    public static $logins = [];

    /**
     * Create a client with a default Authorization header.
     *
     * @param string $username
     * @param string $password
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function createAuthenticatedClient($username = 'admin', $password = 'password')
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $session = $container->get('session');
        /** @var $userManager \FOS\UserBundle\Doctrine\UserManager */
        $userManager = $container->get('fos_user.user_manager');
        /** @var $loginManager \FOS\UserBundle\Security\LoginManager */
        $loginManager = $container->get('fos_user.security.login_manager');
        $firewallName = $container->getParameter('fos_user.firewall_name');

        $user = $container->get('doctrine')->getManager()->getRepository(User::class)->find(2);
        $loginManager->loginUser($firewallName, $user);

        // save the login token into the session and put it in a cookie
        $container->get('session')->set('_security_' . $firewallName, serialize($container->get('security.token_storage')->getToken()));
        $container->get('session')->save();
        $client->getCookieJar()->set(new Cookie($session->getName(), $session->getId()));

        return $client;
    }

}
