<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="config")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ConfigRepository")
 */
class Config
{
  /**
   * @ORM\Column(type="integer")
   * @ORM\Id
   * @ORM\GeneratedValue(strategy="AUTO")
   */
  private $id;

  /**
   * @ORM\Column(name="my_key", type="string", length=30, unique=true)
   */
  private $key;

  /**
   * @ORM\Column(name="my_value", type="string", length=30)
   */
  private $value;

  public function __construct() {

  }

  public function __toString() {
    return $this->key;
  }

  public function getId(){
    return $this->id;
  }

  public function getKey(){
    return $this->key;
  }

  public function getValue(){
    return $this->value;
  }

  public function setKey($key){
    $this->key = $key;
  }

  public function setValue($value){
    $this->value = $value;
  }

}
