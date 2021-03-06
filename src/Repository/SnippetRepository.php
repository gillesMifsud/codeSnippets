<?php

namespace App\Repository;

use App\Entity\Language;
use App\Entity\Snippet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Snippet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Snippet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Snippet[]    findAll()
 * @method Snippet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SnippetRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Snippet::class);
    }

    /**
     * @return Snippet[] Returns an array of Snippet objects
     */
    public function findLatest(): array
    {
        return $this->createQueryBuilder('s')
            ->setMaxResults(8)
            ->getQuery()
            ->getResult()
        ;
    }

    /**
     * @return Query
     */
    public function findAllPaginateQuery(): Query
    {
        return $this->createQueryBuilder('s')
            ->getQuery()
            ;
    }

    /**
     * @param $language
     * @return Snippet[]|null Returns an array of Snippet objects
     */
    public function findAllByLanguage(Language $language): array
    {
        return $this->createQueryBuilder('s')

            ->andWhere('s.id = :val')
            ->setParameter('val', 'BurlyWood')
            ->getQuery()
            ->getResult()
            ;
    }

    /**
     * @param Language $language
     * @return Snippet[] Returns an array of Snippet objects
     */
    public function findSnippetsByLanguage(Language $language)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $languages)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Snippet[] Returns an array of Snippet objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Snippet
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
