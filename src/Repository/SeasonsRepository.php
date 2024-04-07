<?php

namespace App\Repository;

use App\Entity\Season;
use App\Entity\Serie;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Seasons>
 *
 * @method Seasons|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seasons|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seasons[]    findAll()
 * @method Seasons[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeasonsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Season::class);
    }

    public function add(Season $season): void
    {
        $this->getEntityManager()->persist($season);
        $this->getEntityManager()->flush();
    }

    public function update(Season $season): void
    {
        $this->getEntityManager()->persist($season);
        $this->getEntityManager()->flush();
    }

}
