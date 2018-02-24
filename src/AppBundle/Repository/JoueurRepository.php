<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JoueurRepository extends EntityRepository
{
    public function findSH()
    {
      return $this->createQueryBuilder('j')
      ->select('j')
      ->addSelect('g')
      ->leftJoin('j.groupes','g')
      ->where('j.sexe = \'M\'')
      ->andWhere('j.estSimple= true')
      ->orderBy('j.coteSimple','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findSD()
    {
      return $this->createQueryBuilder('j')
      ->select('j')
      ->addSelect('g')
      ->leftJoin('j.groupes','g')
      ->where('j.sexe = \'F\'')
      ->andWhere('j.estSimple = true')
      ->orderBy('j.coteSimple','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findPairesDH()
    {
      return $this->createQueryBuilder('j')
      ->select('j.coteDouble + p.coteDouble as moyenne')
      ->addSelect('\'DH\' as tableau')
      ->addSelect('j')
      ->addSelect('p')
      ->addSelect('g')
      ->join('j.partenaireDH', 'p')
      ->leftJoin('j.groupes','g')
      ->where('j.sexe = \'M\'')
      ->andWhere('j.estDouble = true')
      ->andWhere('j.id < p.id')
      ->orderBy('moyenne','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findPairesDD()
    {
      return $this->createQueryBuilder('j')
      ->select('j.coteDouble + p.coteDouble as moyenne')
      ->addSelect('\'DD\' as tableau')
      ->addSelect('j')
      ->addSelect('p')
      ->addSelect('g')
      ->join('j.partenaireDD', 'p')
      ->leftJoin('j.groupes','g')
      ->where('j.sexe = \'F\'')
      ->andWhere('j.estDouble = true')
      ->andWhere('j.id < p.id')
      ->orderBy('moyenne','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findPairesMX()
    {
      return $this->createQueryBuilder('j')
      ->select('j.coteMixte + p.coteMixte as moyenne')
      ->addSelect('\'MX\' as tableau')
      ->addSelect('j')
      ->addSelect('p')
      ->addSelect('g')
      ->join('j.partenaireMX', 'p')
      ->leftJoin('j.groupes','g')
      ->where('j.sexe = \'M\'')
      ->andWhere('j.estMixte = true')
      ->orderBy('moyenne','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findLaDH(){
      return $this->findBy(array("sexe"=>"M","estDouble"=> true,"partenaireDH" => null),array("coteDouble"=>"DESC"));
    }

    public function findLaDD(){
      return $this->findBy(array("sexe"=>"F","estDouble"=> true,"partenaireDD" => null),array("coteDouble"=>"DESC"));
    }

    public function findLaMX(){
      return $this->findBy(array("estMixte"=> true,"partenaireMX" => null),array("coteMixte"=>"DESC"));
    }
    public function findAllAlpha()
    {
        return $this->createQueryBuilder('j')
        ->select('j')
        ->addSelect('g')
        ->leftJoin('j.groupes','g')
        ->orderBy('j.nom','ASC')
        ->addOrderBy('j.dateInscription','DESC')
        ->getQuery()
        ->getResult();
    }
    public function findAll()
    {
        return $this->findBy(array(),array("dateInscription"=>"DESC","club"=>"ASC","nom"=>"ASC"));
    }

}
