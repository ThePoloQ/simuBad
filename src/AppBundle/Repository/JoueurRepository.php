<?php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class JoueurRepository extends EntityRepository
{
    public function findSH()
    {
        return $this->findBy(array("sexe"=>"M","estSimple"=> true),array("coteSimple"=>"DESC"));
    }

    public function findSD()
    {
        return $this->findBy(array("sexe"=>"F","estSimple"=> true),array("coteSimple"=>"DESC"));
    }

    public function findDH()
    {
      return $this->createQueryBuilder('j')
      ->select('CONCAT(j.nom,\' (\', j.classementDouble ,\')\',\' / \',p.nom,\' (\', p.classementDouble ,\')\') as nom_equipe')
      ->addSelect('j.coteDouble + p.coteDouble as moyenne')
      ->addSelect('j.dateInscription as jDateInscription')
      ->addSelect('p.dateInscription as pDateInscription')
      ->join('j.partenaireDH', 'p')
      ->where('j.sexe = \'M\'')
      ->andWhere('j.estDouble = true')
      ->andWhere('j.id < p.id')
      ->orderBy('moyenne','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findDD()
    {
      return $this->createQueryBuilder('j')
      ->select('CONCAT(j.nom,\' (\', j.classementDouble ,\')\',\' / \',p.nom,\' (\', p.classementDouble ,\')\') as nom_equipe')
      ->addSelect('j.coteDouble + p.coteDouble as moyenne')
      ->addSelect('j.dateInscription as jDateInscription')
      ->addSelect('p.dateInscription as pDateInscription')
      ->join('j.partenaireDD', 'p')
      ->where('j.sexe = \'F\'')
      ->andWhere('j.estDouble = true')
      ->andWhere('j.id < p.id')
      ->orderBy('moyenne','DESC')
      ->getQuery()
      ->getResult();
    }

    public function findMX()
    {
      return $this->createQueryBuilder('j')
      ->select('CONCAT(j.nom,\' (\', j.classementMixte,\')\',\' / \',p.nom,\' (\', p.classementMixte ,\')\') as nom_equipe')
      ->addSelect('j.coteMixte + p.coteMixte as moyenne')
      ->addSelect('j.dateInscription as jDateInscription')
      ->addSelect('p.dateInscription as pDateInscription')
      ->join('j.partenaireMX', 'p')
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

    public function findAll()
    {
        return $this->findBy(array(),array("dateInscription"=>"DESC"));
    }

}
