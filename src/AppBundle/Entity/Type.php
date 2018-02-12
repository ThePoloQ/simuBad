<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="types")
 */
class Type
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=100)
   */
  private $nom;

  /**
   * @ORM\Column(type="integer")
   */
  private $nombre_poules;

  /**
   * @ORM\Column(type="integer")
   */
  private $taille_poule;

  /**
   * @ORM\OneToMany(targetEntity="Groupe", mappedBy="type")
   */
  private $groupes;

  public function __construct() {
    $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
  }

  public function __toString() {
    return $this->nom;
  }

  public function getId(){
    return $this->id;
  }

  public function getNom(){
   return $this->nom;
  }

  public function setNom($nom){
   $this->nom = $nom;
  }

  public function getPrenom(){
   return $this->prenom;
  }

  public function setPrenom($prenom){
   $this->prenom = $prenom;
  }

  public function getNombrePoules(){
   return $this->nombre_poules;
  }

  public function setNombrePoules($nombre_poules){
   $this->nombre_poules = $nombre_poules;
  }

  public function getTaillePoule(){
   return $this->taille_poule;
  }

  public function setTaillePoule($taille_poule){
   $this->taille_poule = $taille_poule;
  }

  public function getGroupes(){
    return $this->groupes;
  }

  public function addGroupe(Groupe $groupe){
    $this->groupes[] = $groupe;
  }

  //Functions add-on

  //nombre de joueurs
  public function getNbJoueurs(){
    return $this->nombre_poules * $this->taille_poule;
  }

  //nombre de match par tour de poule
  public function getNbMatchTour(){
    return \floor($this->taille_poule/2);
  }

  //nombre de matchs de poule pour un joueur
  public function getNbMatchsJP(){
    return $this->taille_poule -1;
  }
  //nombre de tours de poules
  public function getNbTours(){ //3,3,5
    return  $this->getNbMatchsJP() + ($this->taille_poule % 2);
  }

  //nombre de match de poules
  public function getNbMatchsP(){
    return $this->getNbMatchTour() * $this->getNbTours() * $this->nombre_poules;
  }

  //nombre de match phases finales
  public function getNbMatchsPhF(){
    $ret = 0;
    $i = $this->nombre_poules;
    while($i >= 1){
      $ret += $i;
      $i= $i/2;
    }
    return $ret;
  }

  //nombre de matchs phases finales pour un joueur
  public function getNbMatchsJPF(){
    $ret = 0;
    $i = $this->nombre_poules;
    while($i >= 1){
      $ret ++;
      $i= $i/2;
    }
    return $ret;
  }

  //nombre total de matchs sans les demies
  public function getNbMatchsTSD(){
    return $this->getNbMatchsT() - 3;
  }

  //nombre total de matchs
  public function getNbMatchsT(){
    return $this->getNbMatchsP() + $this->getNbMatchsPhF();
  }
}
