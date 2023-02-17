<?php

namespace App\Repository;

use App\Entity\Student;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 *
 * @method Student|null find($id, $lockMode = null, $lockVersion = null)
 * @method Student|null findOneBy(array $criteria, array $orderBy = null)
 * @method Student[]    findAll()
 * @method Student[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StudentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function save(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Student $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Student[] Returns an array of Student objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Student
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

/*    
public function findStudentByEmail(){
        $entityManager = $this->getEntityManager();
        $query = $entityManager
        ->createQuery('SELECT p FROM App\Entity\Student p ORDER BY p.Email ASC');
        return $query->getResult();
    }

    public function showAllStudent($nsc){
        $entityManager = $this->getEntityManager();
        $condition=false;
        if($condition==true){
            $query = $entityManager
        ->createQuery('SELECT s FROM App\Entity\Student s WHERE s.NSC LIKE :nsc')
        ->setParameter('nsc', '%'.$nsc.'%');
        }else{
            $query = $entityManager
        ->createQuery('SELECT s FROM App\Entity\Student s ');
        } 
        return $query->getResult();
    }
    */





    public function trierStudentByEmail(){
        $queryBuilder=$this->createQueryBuilder('s')
                    ->orderBy('s.Email', 'ASC')
                    ->getQuery()
                    ->getResult();
        return $queryBuilder;
    }

    public function trierStudentByEmailDQL(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
                ->createQuery('SELECT s FROM App\Entity\Student s ORDER BY s.Email ASC');
        return $query->getResult();
    }

    public function showAllStudent($email){
        $queryBuilder=$this->createQueryBuilder('s')
                        ->where('s.Email LIKE :email')
                        ->setParameter('email','%'.$email.'%')
                        ->getQuery()
                        ->getResult();
        return $queryBuilder;
        
    }

    public function showAllStudentByClass($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
                ->createQuery('SELECT s FROM App\Entity\Student s JOIN s.classroom c WHERE c.id=:id')
                ->setParameter('id',$id);
        return $query->getResult();
        
    }

    public function showLastStudent(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
                ->createQuery("SELECT s FROM App\Entity\Student s ORDER BY s.creationDate DESC")
                ->setMaxResults(3);
        return $query->getResult();
        
    }

    public function searchBetweenStudent(){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
                ->createQuery("SELECT s FROM App\Entity\Student s WHERE s.creationDate BETWEEN '2022-10-25' AND '2022-10-27'");
        return $query->getResult();
        
    }

    public function calculeMoyenne($id){
        $entityManager=$this->getEntityManager();
        $query=$entityManager
                ->createQuery("SELECT avg(s.moyenne) FROM App\Entity\Student s JOIN s.classroom c WHERE c.id=:id")
                ->setParameter('id',$id);
        return $query->getSingleScalarResult();
        
    }

















}
