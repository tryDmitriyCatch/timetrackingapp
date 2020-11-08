<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Class UserFixture
 * @package App\DataFixtures
 */
class UserFixture extends BaseFixture
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * UserFixture constructor.
     *
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param ObjectManager $manager
     * @return mixed|void
     */
    protected function loadData(ObjectManager $manager)
    {
        $this->createMany(10, 'dummy_users', function ($i) {
            $user = new User();

            $user
                ->setEmail(sprintf('test%d@test.com',  $i))
                ->setName($this->faker->firstName)
                ->setSurname($this->faker->lastName)
                ->setPassword($this->userPasswordEncoder->encodePassword($user, 'test'))
                ->setCreatedAt(new DateTimeImmutable('now'))
                ->setUpdatedAt(new DateTimeImmutable('now'));

            $this->setReference(UserFixture::class, $user);

            return $user;
        });

        $manager->flush();
    }
}
