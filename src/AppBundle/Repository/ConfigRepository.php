<?php
// src/AppBundle/Repository/UserRepository.php
namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ConfigRepository extends EntityRepository
{
  public function getDateLimite()
  {
    return $this->findOneBy(array('key'=>'date_limite_ins'));
  }
  public function getDureeMatch()
  {
    return $this->findOneBy(array('key'=>'duree_match_s'));
  }
  public function getDateCPPH()
  {
    return $this->findOneBy(array('key'=>'date_cpph'));
  }
}
