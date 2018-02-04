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
}
