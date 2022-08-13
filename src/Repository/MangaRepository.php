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


    public function findManga(int $id): array
    {
        $entitymanager = $this->getEntityManager();

        $query = $entitymanager->createQuery(
             'SELECT distinct m.Image, m.Name, m.Price, m.Description, m.create_date, a.Artist_name, g.Genre_name
             FROM App\Entity\Manga m, App\Entity\Artist a, App\Entity\Genre g
             WHERE m.id = :id
             AND m.Artist = a.id AND m.Genre = g.id'
            )->setParameter('id', $id);
        return $query->getResult();
    }

//    public function findMangaByAZ($id): array
//    {
//        $entitymanager = $this->getEntityManager();
//
//        $query = $entitymanager->createQuery(
//            'SELECT distinct m.Image, m.Name, m.Price, m.Description, m.create_date, a.Artist_name, g.Genre_name
//             FROM App\Entity\Manga m, App\Entity\Artist a, App\Entity\Genre g
//             WHERE m.id = :id
//             AND m.Artist = a.id AND m.Genre = g.id
//             ORDER BY m.name ASC'
//
//        )->setParameter('id', $id);
//        return $query->getResult();
//    }
//

//    public function findMangaLatest($value): array
//    {
//        $entitymanager = $this->getEntityManager();
//
//        $query = $entitymanager->createQuery(
//            'SELECT distinct m.Image, m.Name, m.Price, m.Description, m.create_date
//             FROM App\Entity\Manga m
//             WHERE m.create_date > :create_date
//             ORDER BY m.create_date ASC'
//
//        )->setParameter('value', $value);
//        return $query->getResult();
//    }

//    /**
//     * @Return Manga[]
//     */
//
//    public function findMangaLatest($value)
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.create_date >:val')
//            ->setParameter('val', $value)
//            ->orderBy('m.create_date', 'ASC')
//            ->getQuery()
//            ->getResult()
//            ;
//    }




//    public function findMangaWithGenreAndArtist(string $id): array
//    {
//        $conn = $this->getEntityManager()->getConnection();
//
//        $sql = '
//            SELECT m.Name, m.Price, m.description, m.CreateDate, m.Image, a.Artist_name, g.Genre_name *
//            FROM manga m, artist a, genre g
//            WHERE m.id = :a.id AND m.id = :g.id
//            ORDER BY m.id ASC
//        ';
//        $stmt = $conn->prepare($sql);
//        $stmt->execute(['id' => $id]);
//
//        return $stmt->fetchAllAssociative();
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

//    /**
//     * @return Manga[] Returns an array of Manga objects
//     */
//    public function findMangaWithGenreAndArtist($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.id= :val')

//            ->join('m.genre', 'g')
//            ->where('g.GenreName= :val')

//            ->select('m')
//            ->from('Manga', 'm')
//            ->innerJoin('m.manga', 'g', Expr\Join::WITH, 'g.genre = m.manga')
//            ->innerJoin('m.manga', 'a', Expr\Join::WITH, 'a.artist = m.manga')

//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }


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
