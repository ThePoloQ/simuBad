<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="salles")
 */
class Salle
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
  private $nombre_terrains;

  /**
   * @ORM\Column(type="time")
   */
  private $heure_debut;

  /**
   * @ORM\Column(type="time")
   */
  private $heure_fin;

  /**
   * @ORM\OneToMany(targetEntity="Groupe", mappedBy="salle")
   */
  private $groupes;

  /**
   * @ORM\OneToMany(targetEntity="Groupe", mappedBy="salleDF")
   */
  private $groupesDF;

  //duree d'un match en secondes (30minutes)
  const DUREEMATCH = 1800;

  public function __construct() {
    $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
    $this->groupesDF = new \Doctrine\Common\Collections\ArrayCollection();
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

  public function getNombreTerrains(){
    return $this->nombre_terrains;
  }

  public function setNombreTerrains($nombre_terrains){
    $this->nombre_terrains = $nombre_terrains;
  }

  public function getHeureDebut(){
    return $this->heure_debut;
  }

  public function setHeureDebut($heure_debut){
    $this->heure_debut = $heure_debut;
  }

  public function getHeureFin(){
    return $this->heure_fin;
  }

  public function setHeureFin($heure_fin){
    $this->heure_fin = $heure_fin;
  }

  public function getGroupes(){
    return $this->groupes;
  }

  public function addGroupe(Groupe $groupe){
    $this->groupes[] = $groupe;
  }

  public function getGroupesDF(){
    return $this->groupesDF;
  }

  public function addGroupeDF(Groupe $groupeDF){
    $this->groupesDF[] = $groupeDF;
  }

  public function getCapacite(){
    $diff = $this->heure_debut->diff($this->heure_fin);
    $sec = \date_create('@0')->add($diff)->getTimestamp();

    return ($sec/self::DUREEMATCH) * $this->getNombreTerrains();
  }

}
