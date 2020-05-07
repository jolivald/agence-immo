<?php

namespace App\Repository;

use App\Entity\Property;
use App\Entity\PropertySearch;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Property|null find($id, $lockMode = null, $lockVersion = null)
 * @method Property|null findOneBy(array $criteria, array $orderBy = null)
 * @method Property[]    findAll()
 * @method Property[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Property::class);
    }

    private function findVisibleQueryBuilder(): QueryBuilder {
        return $this->createQueryBuilder('p')
            ->where('p.sold = false');

    }

    public function findAllVisibleQuery(PropertySearch $search): Query {
        $query = $this->findVisibleQueryBuilder();
        if ($search->getMaxPrice()){
            $query = $query
                ->andWhere('p.price < :maxPrice')
                ->setParameter('maxPrice', $search->getMaxPrice());
        }
        if ($search->getMinSurface()){
            $query = $query
                ->andWhere('p.surface > :minSurface')
                ->setParameter('minSurface', $search->getMinSurface());
        }
        if ($search->getOptions()->count() > 0){
            $id = 0;
            foreach($search->getOptions() as $option){
                $id++;
                $query = $query
                    ->andWhere(":option$id MEMBER OF p.options")
                    ->setParameter("option$id", $option);
            }
        }
        return $query->getQuery();
    }

    public function findLatest() {
        return $this->findVisibleQueryBuilder()
            ->setMaxResults(4)
            ->getQuery()
            ->getResult();

    }
    // /**
    //  * @return Property[] Returns an array of Property objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Property
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
