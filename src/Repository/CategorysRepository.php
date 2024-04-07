<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Categorys>
 *
 * @method Categorys|null find($id, $lockMode = null, $lockVersion = null)
 * @method Categorys|null findOneBy(array $criteria, array $orderBy = null)
 * @method Categorys[]    findAll()
 * @method Categorys[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategorysRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function add(Category $category): void
    {
        $this->getEntityManager()->persist($category);
        $this->getEntityManager()->flush();
    }


    public function insertAllIgnoreDuplicate(array $categorys)
    {
        $query = 'INSERT IGNORE INTO categorys (tmdb_category_id, name) VALUES ';
        $conn = $this->getEntityManager()->getConnection();

        foreach ($categorys as $category) {
            $query .=  '('.$category->getTmdbCategoryId().', "'.$category->getName().'"),';
        }
        
        $conn->executeStatement(trim($query,','));
    }

    public function getCategorysNames($categorys){
        $categorys = implode(',', $categorys);
        $query = $this->createQueryBuilder('c')
            ->select("c.name")
            ->where('c.tmdb_category_id IN (:categorys)')
            ->setParameter('categorys', $categorys)
            ->getQuery();

        $categoryNames = $query->getResult();
        $catString = '';
        foreach ($categoryNames as $key => $value) {
            $catString .= $value['name'].',';
        }
        return trim($catString,',');
    }
}
