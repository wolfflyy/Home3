<?php

namespace App\Repository;

use App\Entity\Manga;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Manga>
 *
 * @method Manga|null find($id, $lockMode = null, $lockVersion = null)
 * @method Manga|null findOneBy(array $criteria, array $orderBy = null)
 * @method Manga[]    findAll()
 * @method Manga[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MangaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Manga::class);
    }

    public function add(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Manga $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


//    public function findAllMangaWithLimit($id): ?Manga
//    {
//        $entitymanager = $this->getEntityManager();
//
//        $query = $entitymanager->createQuery(
//            'SELECT m
//            FROM App\Entity\Manga m
//            WHERE m.id = :id
//            ORDER BY m.id ASC'
//            )->setParameter('id', $id);
//        return $query->getResult();
//    }


//    /**
//     * @return Manga[]
//     */
//    public function findMangaWithGenreAndArtist()
//    {
//        return $this->MangaWithGenreAndArtist()
//            ->leftJoin('m.genre', 'genre_name')
//            ->innerJoin('genre_name.artist', 'artist_name')
//            ->addSelect('genre_name', 'artist_name')
//            ->setMaxResults('30')
//            ->getQuery()
//            ->getResult()
//            ;
//    }
//
//    private function MangaWithGenreAndArtist(QueryBuilder $qb = null): QueryBuilder
//    {
//        return $this->getOrCreateQueryBuilder($qb)
//            ->andWhere('m.manga IS NOT NULL');
//    }
//
//    private function getOrCreateQueryBuilder(QueryBuilder $qb = null): QueryBuilder
//    {
//        return $qb ?: $this->createQueryBuilder('m');
//    }

    /**
     * @return Manga[] Returns an array of Manga objects
     */
    public function findMangaWithGenreAndArtist($value): array
    {
        return $this->createQueryBuilder('m')
//            ->andWhere('m.id= :val')
            ->join('m.genre', 'g')
            ->where('g.GenreName= :val')
//            ->select('m')
//            ->from('Manga', 'm')
//            ->innerJoin('m.manga', 'g', Expr\Join::WITH, 'g.genre = m.manga')
//            ->innerJoin('m.manga', 'a', Expr\Join::WITH, 'a.artist = m.manga')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }


//    public function findOneBySomeField($value): ?Manga
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
