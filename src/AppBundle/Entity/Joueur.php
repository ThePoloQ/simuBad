<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="joueurs")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\JoueurRepository")
 */
class Joueur
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
   * @ORM\Column(type="string", length=100, nullable=true)
   */
  private $prenom;

  /**
   * @ORM\Column(type="integer")
   */
  private $licence;

  /**
   * @ORM\Column(type="string", length=100, nullable=true)
   */
  private $club;

  /**
   * @ORM\Column(type="string", length=1)
   */
  private $sexe;

  /**
   * @ORM\Column(type="boolean", nullable=true, options={"default" : false})
   */
  private $estLA;

  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $estSimple;

  /**
   * @ORM\Column(type="string", length=3, nullable=true)
   */
  private $classementSimple;

  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $estDouble;

  /**
   * @ORM\Column(type="string", length=3, nullable=true)
   */
  private $classementDouble;

  /**
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $estMixte;

  /**
   * @ORM\Column(type="string", length=3, nullable=true)
   */
  private $classementMixte;

  /**
   * @ORM\Column(type="date")
   */
  private $dateInscription;

  /**
   * @ORM\Column(type="float", nullable=true, options={"default":0})
   */
  private $coteSimple;

  /**
   * @ORM\Column(type="float", nullable=true, options={"default":0})
   */
  private $coteDouble;

  /**
   * @ORM\Column(type="float", nullable=true, options={"default":0})
   */
  private $coteMixte;

  /**
   * @ORM\OneToOne(targetEntity="Joueur")
   * @ORM\JoinColumn(name="dh_id", referencedColumnName="id")
   */
  private $partenaireDH;

  /**
   * @ORM\Column(type="integer", name="dh_id", nullable=true)
   */
  private $DhId;

  /**
   * @ORM\OneToOne(targetEntity="Joueur")
   * @ORM\JoinColumn(name="dd_id", referencedColumnName="id")
   */
  private $partenaireDD;

  /**
   * @ORM\Column(type="integer", name="dd_id", nullable=true)
   */
  private $DdId;

  /**
   * @ORM\OneToOne(targetEntity="Joueur")
   * @ORM\JoinColumn(name="mx_id", referencedColumnName="id")
   */
  private $partenaireMX;

  /**
   * @ORM\Column(type="integer", name="mx_id", nullable=true)
   */
  private $MxId;

  /**
   * @ORM\ManyToMany(targetEntity="Groupe", mappedBy="joueurs", cascade={"persist"})
   */
  private $groupes;

  public function __construct() {
    $this->groupes = new \Doctrine\Common\Collections\ArrayCollection();
  }

  public function __toString() {
    return $this->nom." ".$this->prenom;
  }

  public function setId(){
    return $this->id;
  }

  public function getId(){
    return $this->id;
  }

  public function getDhId(){
    return $this->DhId;
  }

  public function setDhId($id){
    $this->DhId = $id;
  }

  public function getDdId(){
    return $this->DdId;
  }

  public function setDdId($id){
    $this->DdId = $id;
  }

  public function getMxId(){
    return $this->MxId;
  }

  public function setMxId($id){
    $this->MxId = $id;
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

  public function getLicence(){
    return $this->licence;
  }

  public function setLicence($licence){
    $this->licence = $licence;
  }

  public function getPartenaireDH(){
    return $this->partenaireDH;
  }

  public function setPartenaireDH($partenaireDH = null){
    $this->partenaireDH = $partenaireDH;

    if (!$partenaireDH && $this->getPartenaireDH())
      $this->getPartenaireDH()->setPartenaireDH(null);

    if ($partenaireDH && (!$partenaireDH->getPartenaireDH() || $partenaireDH->getPartenaireDH()->getId() != $this->getId()))
      $partenaireDH->setPartenaireDH($this);
  }

  public function getPartenaireDD(){
    return $this->partenaireDD;
  }

  public function setPartenaireDD($partenaireDD = null){
    $this->partenaireDD = $partenaireDD;

    if (!$partenaireDD && $this->getPartenaireDD())
      $this->getPartenaireDD()->setPartenaireDD(null);

    if ($partenaireDD && (!$partenaireDD->getPartenaireDD() || $partenaireDD->getPartenaireDD()->getId() != $this->getId()))
      $partenaireDD->setPartenaireDD($this);
  }

  public function getPartenaireMX(){
    return $this->partenaireMX;
  }

  public function setPartenaireMX($partenaireMX = null){
    $this->partenaireMX = $partenaireMX;

    if (!$partenaireMX && $this->getPartenaireMX())
      $this->getPartenaireMX()->setPartenaireMX(null);


    if ($partenaireMX && (!$partenaireMX->getPartenaireMX() || $partenaireMX->getPartenaireMX()->getId() != $this->getId()))
      $partenaireMX->setPartenaireMX($this);
  }

  public function getGroupes(){
    return $this->groupes;
  }
  

  public function removeGroupe($groupe){
    if (!$this->groupes->contains($groupe)){
      return;
    }
    $this->groupes->removeElement($groupe);
    $groupe->removeJoueur($this);
  }

  public function removeAllGroupes(){
    if($this->groupes->count()==0) return;
    $this->groupes->clear();
    foreach ($$this->groupes as $groupe) {
      $groupe->removeJoueur($this);
    }
  }

  public function getGroupe($type = 'SH'){
    foreach ($this->groupes as $key => $groupe) {
      if ($groupe->getTableau() == "$type")
        return $groupe;
    }
    return null;
  }

  public function addGroupe($groupe){
    if ($this->groupes->contains($groupe)){
      return;
    }
    $this->groupes[] = $groupe;
    $groupe->addJoueur($this);
  }

  public function getClub(){
		return $this->club;
	}

	public function setClub($club){
		$this->club = $club;
	}

  public function getSexe(){
		return $this->sexe;
	}

	public function setSexe($sexe){
		$this->sexe = $sexe;
	}

	public function getDateInscription(){
		return $this->dateInscription;
	}

	public function setDateInscription($dateInscription){
		$this->dateInscription = $dateInscription;
	}

	public function getCoteSimple(){
		return $this->coteSimple;
	}

	public function setCoteSimple($coteSimple){
		$this->coteSimple = $coteSimple;
	}

	public function getCoteDouble(){
		return $this->coteDouble;
	}

	public function setCoteDouble($coteDouble){
		$this->coteDouble = $coteDouble;
	}

	public function getCoteMixte(){
		return $this->coteMixte;
	}

	public function setCoteMixte($coteMixte){
		$this->coteMixte = $coteMixte;
	}

  public function getEstSimple(){
		return $this->estSimple;
	}

	public function setEstSimple($simple){
		$this->estSimple = $simple;
	}

  public function getEstDouble(){
		return $this->estDouble;
	}

	public function setEstDouble($double){
		$this->estDouble = $double;
	}

  public function getEstMixte(){
		return $this->estMixte;
	}

	public function setEstMixte($mixte){
		$this->estMixte = $mixte;
	}

  public function getEstLA(){
		return $this->estLA;
	}

	public function setEstLA($bool){
		$this->estLA = $bool;
	}

  public function getClassementMixte(){
		return $this->classementMixte;
	}

	public function setClassementMixte($cl){
		$this->classementMixte = $cl;
	}

  public function getClassementSimple(){
		return $this->classementSimple;
	}

	public function setClassementSimple($cl){
		$this->classementSimple = $cl;
	}

  public function getClassementDouble(){
		return $this->classementDouble;
	}

	public function setClassementDouble($cl){
		$this->classementDouble = $cl;
	}
}
