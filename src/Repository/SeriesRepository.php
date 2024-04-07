<?php

namespace App\Repository;

use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Series>
 *
 * @method Series|null find($id, $lockMode = null, $lockVersion = null)
 * @method Series|null findOneBy(array $criteria, array $orderBy = null)
 * @method Series[]    findAll()
 * @method Series[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeriesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Serie::class);
    }

    public function add(Serie $serie): void
    {
        $this->getEntityManager()->persist($serie);
        $this->getEntityManager()->flush();
    }

    public function remove(Serie $serie): void
    {
        $this->getEntityManager()->remove($serie);
        $this->getEntityManager()->flush();
    }

    public function update(Serie $serie): void
    {
        $this->getEntityManager()->persist($serie);
        $this->getEntityManager()->flush();
    }

    public function findBySlug(String $slug): Serie
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.slug = :val')
            ->setParameter('val', $slug)
            ->leftJoin('s.seasons', 'se')
            ->addSelect('se')
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    /**
     * Finds a series by its name.
     * TO DO: In the future, it is ideal to use a database like Elasticsearch that allows registering synonyms 
     * and has a more exact and performant scoring search
     */

    public function findByName(String $name): ?Serie
    {
        $name = trim($name);

        $exactMatch = $this->createQueryBuilder('s')
            ->andWhere('LOWER(s.name) = LOWER(:val)')
            ->setParameter('val', $name)
            ->leftJoin('s.seasons', 'se')
            ->addSelect('se')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($exactMatch) {
            return $exactMatch;
        }

        $likeStart = $this->createQueryBuilder('s')
            ->andWhere('LOWER(s.name) LIKE :val')
            ->setParameter('val', strtolower($name) . '%')
            ->leftJoin('s.seasons', 'se')
            ->addSelect('se')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        if ($likeStart) {
            return $likeStart;
        }

        $likeEnd = $this->createQueryBuilder('s')
            ->andWhere('LOWER(s.name) LIKE :val')
            ->setParameter('val', '%' . strtolower($name) . '%')
            ->leftJoin('s.seasons', 'se')
            ->addSelect('se')
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();

        return $likeEnd;
    }
    

}
