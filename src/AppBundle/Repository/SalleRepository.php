<?php
// src/AppBundle/Repository/UserRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class SalleRepository extends EntityRepository
{
  public function findAll()
  {
    return $this->createQueryBuilder('s')
    ->select('s')
    ->addSelect('t')
    ->addSelect('g')
    ->leftjoin('s.groupes', 'g')
    ->leftJoin('g.type','t')
    ->getQuery()
    ->getResult();
  }
}
