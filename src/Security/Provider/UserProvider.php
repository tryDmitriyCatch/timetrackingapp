<?php

declare(strict_types=1);

namespace App\Security\Provider;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Traits\DemTrait;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\Security\Core\Exception\AuthenticationExpiredException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class UserProvider
 * @package App\Security\Provider
 */
class UserProvider implements UserProviderInterface
{
    use DemTrait;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * UserProvider constructor.
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->userRepository = $entityManager->getRepository(User::class);
        $this->dem = $entityManager;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        try {
            $user = $this->userRepository->loadUserByUsername($username);
        } catch (NonUniqueResultException $exc) {
            throw new UsernameNotFoundException();
        }

        if (is_null($user)) {
            throw new UsernameNotFoundException();
        }

        return $user;
    }

    /**
     * {@inheritDoc}
     *
     * @throws AuthenticationExpiredException
     */
    public function refreshUser(UserInterface $user)
    {
        if (!$this->supportsClass(get_class($user))) {
            throw new UnsupportedUserException();
        }

        return $this->userRepository->find($user);
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return $class === User::class
            || $this->dem->getClassMetadata($class)->getName() === User::class
            ;
    }
}
