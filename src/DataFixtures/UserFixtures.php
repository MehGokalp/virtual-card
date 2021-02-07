<?php

namespace VirtualCard\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use VirtualCard\Entity\User;

class UserFixtures extends Fixture
{
    /** @var UserPasswordEncoderInterface */
    private $userPasswordEncoder;

    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('test@virtualcard.com');

        $user->setPassword($this->userPasswordEncoder->encodePassword($user, '321321'));
        $user->setApiToken('testapitoken');

        $manager->persist($user);
        $manager->flush();
    }
}
