<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements UserLoaderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @param $usernameOrEmail
     * @return int|mixed|string|null
     * @throws NonUniqueResultException
     */
    public function loadUserByUsername($usernameOrEmail)
    {
        $entityManager = $this->getEntityManager();

        return $entityManager->createQuery(
            'SELECT u
                FROM App\Entity\User u
                WHERE u.email = :email'
        )
            ->setParameter('email', $usernameOrEmail)
            ->getOneOrNullResult();
    }
}
