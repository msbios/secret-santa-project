<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    // /**
    //  * @return User[] Returns an array of User objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?User
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
    /**
     * @param User $user
     * @return array
     */
    public function findChildFor(User $user): array
    {
        $all = $this->findAll();
        $result = [];
        foreach ($all as $item) {
            if (!$item->getId()->equals($user->getId())) {
                $result[] = $item;
            }
        }

        return $result;

        // /** @var QueryBuilder $qb */
        // $qb = $this->createQueryBuilder('u');
        // $qb->where($qb->expr()->neq('u.id', $user->getId()));
        // return $qb->getQuery()->getResult();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function hasSanta(User $user)
    {
        $user = $this->findOneBy(['child' => $user->getId()->toString()]);
        return $user instanceof UserInterface;
    }
}
