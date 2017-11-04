<?php


namespace AppBundle\DataFixtures\ORM;

use CoreBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // create 5 users! Bam!
        for ($i = 0; $i < 5; $i++) {
            $user = new User();
            $user->setUsername('user' . $i);
            $user->setEmail("test" . $i . "@email.com");
            $user->setPlainPassword("abc123");
            $user->setIsActive((bool) rand(0,1));
            $manager->persist($user);
        }
        $zrino = new User();
        $zrino->setUsername('zrino');
        $zrino->setEmail("zrino.pernar@gmail.com");
        $zrino->setPlainPassword("abc123");
        $zrino->setIsActive(1);

        $this->addReference('admin-user', $zrino);

        $manager->flush();
    }
}