<?php
// src/AppBundle/Repository/UserRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class GroupeRepository extends EntityRepository
{
    public function findSH()
    {
        return $this->findBy(array("tableau" => "SH"),array("nom"=>"ASC"));
    }

    public function findSD()
    {
        return $this->findBy(array("tableau" => "SD"),array("nom"=>"ASC"));
    }

    public function findDH()
    {
        return $this->findBy(array("tableau" => "DH"),array("nom"=>"ASC"));
    }

    public function findDD()
    {
        return $this->findBy(array("tableau" => "DD"),array("nom"=>"ASC"));
    }

    public function findMX()
    {
        return $this->findBy(array("tableau" => "MX"),array("nom"=>"ASC"));
    }

    public function findAll()
    {
        return $this->createQueryBuilder('g')
        ->select('g')
        ->addSelect('t')
        ->addSelect('g')
        ->join('g.type','t')
        ->orderBy('g.nom','ASC')
        ->getQuery()
        ->getResult();
    }
}
