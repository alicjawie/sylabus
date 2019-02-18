<?php

namespace AppBundle\DataFixtures\ORM\Test;

use AppBundle\DataFixtures\ORM\AbstractYamlFixture;
use AppBundle\Entity\User;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadUserData extends AbstractYamlFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    const ORDER = 1;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function getModelFile()
    {
        return 'user';
    }

    public function load(ObjectManager $manager)
    {
        $users = $this->getModelFixtures();
        $userManager = $this->container->get('fos_user.user_manager');

        foreach ($users['User'] as $key => $columns) {
            $user = new User();

            $user->setUsername($columns['username']);
            $user->setName($columns['name']);
            $user->setSurname($columns['surname']);
            $user->setIndex($columns['index']);
            $user->setEmail($columns['email']);
            $user->setPlainPassword($columns['password']);
            $user->setEnabled(true);

            $user->setRoles($columns['roles']);

            $userManager->updateUser($user, true);

            $this->addReference('user-'.$key, $user);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return self::ORDER;
    }
}
