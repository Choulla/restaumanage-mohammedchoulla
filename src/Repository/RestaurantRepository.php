<?php

namespace App\Repository;

use App\Entity\Restaurant;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Restaurant|null find($id, $lockMode = null, $lockVersion = null)
 * @method Restaurant|null findOneBy(array $criteria, array $orderBy = null)
 * @method Restaurant[]    findAll()
 * @method Restaurant[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RestaurantRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Restaurant::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Restaurant $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Restaurant $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Restaurant[] Returns an array of Restaurant objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Restaurant
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function lastCreatedRestaurants(int $limit){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            '
            SELECT r FROM App\Entity\Restaurant r
            ORDER BY r.id DESC 
            '
        )->setMaxResults($limit);
        return $query->getResult();
    }
    public function avgValueOfRestaunat(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            '
            SELECT AVG(re.rating) , r.name
            from App\Entity\Restaurant r , App\Entity\Review re
            WHERE r.id = re.restaurant_id
            GROUP BY r.name
            '
        );
        return $query->getResult();
    }
    public function theThreebestRestaurants(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            '
            SELECT r.name , AVG(re.rating) average
            from App\Entity\Restaurant r , App\Entity\Review re
            WHERE r.id = re.restaurant_id
            GROUP BY r.name
            order by average DESC
            '
        )->setMaxResults(3);
        return $query->getResult();
    }
    public function restaurantsDetails(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            '
            SELECT r,re,city
            from App\Entity\Restaurant r , App\Entity\Review re , App\Entity\City city
            WHERE r.id = re.restaurant_id
            and r.city_id = city.id
            '
        );
        return $query->getResult();
    }
    public function restaurantNotVoted(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            '
            SELECT r.name , r.description from App\Entity\Restaurant r
            where r.id not in (
            select res.id 
            from App\Entity\Restaurant res, App\Entity\Review re
            where res.id = re.restaurant_id
            )
            '
        );
        return $query->getResult();
    }
}
