<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="groupes")
 */
class Groupe
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
   * @ORM\Column(type="string", length=5, nullable=true)
   */
  private $tableau;


  /**
   * @ORM\ManyToOne(targetEntity="Type", inversedBy="groupes")
   * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
   */
  private $type;

  /**
   * @ORM\ManyToMany(targetEntity="Joueur", inversedBy="groupes")
   */
  private $joueurs;

  /**
   * @ORM\ManyToOne(targetEntity="Salle", inversedBy="groupes")
   * @ORM\JoinColumn(name="salle_id", referencedColumnName="id")
   */
  private $salle;

  /**
   * @ORM\ManyToOne(targetEntity="Salle", inversedBy="groupesDF")
   * @ORM\JoinColumn(name="salledf_id", referencedColumnName="id")
   */
  private $salleDF;

  public function __construct() {
    $this->joueurs = new \Doctrine\Common\Collections\ArrayCollection();
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

  public function getTableau(){
    return $this->tableau;
  }

  public function setTableau($tableau){
    $this->tableau = $tableau;
  }

  public function getType(){
    return $this->type;
  }

  public function setType(Type $type){
    $this->type = $type;
  }

  public function getJoueurs(){
    return $this->joueurs;
  }

  public function addJoueur(Joueur $joueur){
    $this->joueurs[] = $joueur;
  }

  public function getSalle(){
    return $this->salle;
  }

  public function setSalle(Salle $salle){
    $this->salle = $salle;
  }

  public function getSalleDF(){
    return $this->salleDF;
  }

  public function setSalleDF(Salle $salleDF){
    $this->salleDF = $salleDF;
  }
}
