<?php

namespace App\Repository;

use App\Entity\OrderSession;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<OrderSession>
 *
 * @method OrderSession|null find($id, $lockMode = null, $lockVersion = null)
 * @method OrderSession findOneBy(array $criteria, array $orderBy)
 * @method OrderSession[]    findAll()
 * @method OrderSession[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OrderSessionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrderSession::class);
    }

    public function add(OrderSession $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(OrderSession $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * Finds carts that have not been modified since the given date.
//     *
//     * @param \DateTime $limitDate
//     * @param int $limit
//     *
//     * @return int|mixed|string
//     */
//    public function findCartsNotModifiedSince(\DateTime $limitDate, int $limit = 10): array
//    {
//        return $this->createQueryBuilder('o')
//            ->andWhere('o.status = :status')
//            ->andWhere('o.updatedAt < :date')
//            ->setParameter('status', OrderSession::STATUS_CART)
//            ->setParameter('date', $limitDate)
//            ->setParameter('limit', $limit)
//            ->setMaxResults($limit)
//            ->getQuery()
//            ->getResult()
//            ;
//    }


    /**
     * Finds carts that have not been modified since the given date.
     *
     * @param \DateTime $limitDate
     * @param int $limit
     *
     * @return int|mixed|string
     */
    public function findCartsNotModifiedSince(\DateTime $limitDate, $limit): array
    {
        $entitymanager = $this->getEntityManager();

        $query = $entitymanager->createQuery(
            'SELECT o.status
             FROM App\Entity\OrderSession o
             WHERE o.status = :status
             AND o.updatedAt < :date
             LIMIT:limit
             '

        )->setParameter('status', OrderSession::STATUS_CART)
        ->setParameter('date', $limitDate)
        ->setParameter('limit', $limit);

        return $query->getResult();
    }


//    /**
//     * @return Order[] Returns an array of Order objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Order
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
