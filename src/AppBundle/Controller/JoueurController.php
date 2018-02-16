<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Joueur controller.
 *
 * @Route("joueur")
 */
class JoueurController extends Controller
{
    /**
     * Lists all joueur entities.
     *
     * @Route("/", name="joueur_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $joueurs = $em->getRepository('AppBundle:Joueur')->findAll();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/index.html.twig', array(
            'joueurs' => $joueurs,
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/sh", name="joueur_sh")
     * @Method("GET")
     */
    public function shAction()
    {
        $em = $this->getDoctrine()->getManager();

        $joueurs = $em->getRepository('AppBundle:Joueur')->findSH();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
            'type' => 'SH',
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/sd", name="joueur_sd")
     * @Method("GET")
     */
    public function sdAction()
    {
        $em = $this->getDoctrine()->getManager();

        $joueurs = $em->getRepository('AppBundle:Joueur')->findSD();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
            'type' => 'SD',
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/dh", name="joueur_dh")
     * @Method("GET")
     */
    public function dhAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('AppBundle:Joueur')->findPairesDH();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/equipes.html.twig', array(
            'equipes' => $equipes,
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/dd", name="joueur_dd")
     * @Method("GET")
     */
    public function ddAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('AppBundle:Joueur')->findPairesDD();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/equipes.html.twig', array(
            'equipes' => $equipes,
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/mx", name="joueur_mx")
     * @Method("GET")
     */
    public function mxAction()
    {
        $em = $this->getDoctrine()->getManager();
        $equipes = $em->getRepository('AppBundle:Joueur')->findPairesMX();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/equipes.html.twig', array(
            'equipes' => $equipes,
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/sous/x/dh", name="joueur_la_dh")
     * @Method("GET")
     */
    public function laDhAction()
    {
        $em = $this->getDoctrine()->getManager();

        $joueurs = $em->getRepository('AppBundle:Joueur')->findLaDH();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
            'type' => 'DH',
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/sous/x/dd", name="joueur_la_dd")
     * @Method("GET")
     */
    public function laDdAction()
    {
        $em = $this->getDoctrine()->getManager();

        $joueurs = $em->getRepository('AppBundle:Joueur')->findLaDD();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
            'type' => 'DD',
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Lists all joueur entities.
     *
     * @Route("/sous/x/mx", name="joueur_la_mx")
     * @Method("GET")
     */
    public function laMxAction()
    {
        $em = $this->getDoctrine()->getManager();

        $joueurs = $em->getRepository('AppBundle:Joueur')->findLaMX();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
            'type' => 'MX',
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Import joueur.
     *
     * @Route("/importer", name="joueur_importer")
     * @Method({"GET", "POST"})
     */
    public function importerAction(Request $request)
    {
      $form = $this->createFormBuilder()
              ->add('submitFile', FileType::class, array('label' => 'Importer un fichier'))
              ->add('maj', ChoiceType::class, array(
              'label' => "Mettre à jour les moyennes",
              'choices'  => array(
                  '' => false,
                  'Oui' => true,
              )))
              ->add('dateformat', ChoiceType::class, array(
              'label' => "Format des dates",
              'choices'  => array(
                  'd/m/Y - ex: 24/01/2018' => 'd/m/Y',
                  'n/j/Y - ex: 1/30/2018' => 'n/j/Y',
              )))
              ->add('delemiter', ChoiceType::class, array(
              'label' => "Délemiteur",
              'choices'  => array(
                  ';' => ';',
                  ',' => ',',
              )))
              ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $file = $form->get('submitFile');
        $dateFormat = $form->get('dateformat')->getData();
        $doMaj = $form->get('maj')->getData();
        $delemiter= $form->get('delemiter')->getData();
        $upFile=$file->getData();
        if(in_array($upFile->getMimeType(),array("text/plain","text/csv"))){
            $rows = str_getcsv(file_get_contents($upFile->getPathname()), "\n");
            foreach($rows as $key => $row){
              $valeurs = str_getcsv($row,$delemiter);
              if ($key == 0) {
                //Nom,L,Sexe,Date,Simple,Double,Partenaire double,L,Mixte,Partenaire mixte,L
                //verification de l entete pour valider le fichier
                if ( $valeurs[0]!="Nom" ||
                     $valeurs[1]!="L" ||
                     $valeurs[2]!="Sexe" ||
                     $valeurs[3]!="Date" ||
                     $valeurs[4]!="Simple" ||
                     $valeurs[5]!="Double" ||
                     $valeurs[6]!="Partenaire double" ||
                     $valeurs[7]!="L" ||
                     $valeurs[8]!="Mixte" ||
                     $valeurs[9]!="Partenaire mixte" ||
                     $valeurs[10]!="L"){
                  return $this->render('joueur/importer.html.twig', array(
                    'form' => $form->createView(),
                    'message' => 'ERREUR: Mauvais format de fichier - Import impossible',
                  ));
                }else{
                  continue;
                }
              }
              $joueur = $em->getRepository('AppBundle:Joueur')->findOneBy(array("licence" => \intval($valeurs[1])));
              if (!$joueur) {
                $joueur = New Joueur();
                $joueur->setLicence(\intval($valeurs[1]));
              }
              $joueur->setNom($valeurs[0]);
              $joueur->setSexe($valeurs[2]);
              $joueur->setDateInscription(\DateTime::createFromFormat($dateFormat, $valeurs[3]));

              if($valeurs[4]!="")
                $joueur->setEstSimple(true);

              if($valeurs[5]!=""){
                $joueur->setEstDouble(true);
                if($valeurs[7]!=""){
                  $part = $em->getRepository('AppBundle:Joueur')->findOneBy(array("licence" => \intval($valeurs[7])));
                  if($part && $valeurs[2] == "M"){
                    $joueur->setPartenaireDH($part);
                    $joueur->setPartenaireDD(null);
                  }elseif($part && $valeurs[2] == "F"){
                    $joueur->setPartenaireDD($part);
                    $joueur->setPartenaireDH(null);
                  }
                }
              }else{
                $joueur->setEstDouble(false);
                $joueur->setPartenaireDD(null);
                $joueur->setPartenaireDH(null);
              }
              if($valeurs[8]!=""){
                $joueur->setEstMixte(true);
                if($valeurs[10]!=""){
                  $part = $em->getRepository('AppBundle:Joueur')->findOneBy(array("licence" => \intval($valeurs[10])));
                  if($part){
                    $joueur->setPartenaireMX($part);
                  }
                }
              }else{
                $joueur->setEstMixte(false);
                $joueur->setPartenaireMX(null);
              }

              $em->persist($joueur);
              $em->flush();
            }
        }

        if ($doMaj){
          $this->doMajMoyennes(new \DateTime('now'));
        }

        return $this->redirectToRoute('joueur_index');
       }

      return $this->render('joueur/importer.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    /**
     * Import joueur.
     *
     * @Route("/moyenne", name="joueur_moyenne")
     * @Method({"GET", "POST"})
     */
    public function moyenneAction(Request $request)
    {
      $form = $this->createFormBuilder()
              ->add('date', DateType::class, array(
                'label' => "Date du classement",
                'format' => 'dd-MM-yyyy',
                'data' => new \DateTime('now'),
              ))
              ->add('maj', ChoiceType::class, array(
              'label' => "Mettre à jour les moyennes",
              'choices'  => array(
                  '' => false,
                  'Oui' => true,
              )))
              ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        if ($form->get('maj')->getData() == true){
          $this->doMajMoyennes($form->get('date')->getData());
          return $this->redirectToRoute('joueur_index');
        };
       }

      return $this->render('joueur/moyenne.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    private function doMajMoyennes($date){
      if (!$date) return;
      $em = $this->getDoctrine()->getManager();
      $joueurs = $em->getRepository('AppBundle:Joueur')
      ->createQueryBuilder('j')
      ->select('j.licence as licence')
      ->setMaxResults(500)
      ->getQuery()
      ->getResult();
      $licences = array();
      foreach ($joueurs as $j) {
        $licences[] = sprintf("%'.08d", $j["licence"]);
      }
      $sDate = $date->format('Y-m-d');
      $url=$this->getParameter('ffbad_url').'?AuthJson={"Login":"'.$this->getParameter('ffbad_login').'","Password":"'.$this->getParameter('ffbad_password').'"}&QueryJson={"Function":"ws_getrankingallbyarrayoflicencedate","Param":{"Param1":'.json_encode($licences).',"Param2":"'.$sDate.'"}}';
      $output=file_get_contents($url);
      $res = json_decode($output,true);
      //var_dump($res);die();
      $moyennes = $res["Retour"];
      foreach ($moyennes as $m) {
        $em->createQueryBuilder()
        ->update('AppBundle:Joueur','j')
        ->set('j.coteSimple','?1')
        ->set('j.coteDouble','?2')
        ->set('j.coteMixte','?3')
        ->set('j.classementSimple','?4')
        ->set('j.classementDouble','?5')
        ->set('j.classementMixte','?6')
        ->set('j.club','?7')
        ->where('j.licence = ?8')
        ->setParameter(1, $m['SIMPLE_COTE_FFBAD'])
        ->setParameter(2, $m['DOUBLE_COTE_FFBAD'])
        ->setParameter(3, $m['MIXTE_COTE_FFBAD'])
        ->setParameter(4, $m['SIMPLE_NOM'])
        ->setParameter(5, $m['DOUBLE_NOM'])
        ->setParameter(6, $m['MIXTE_NOM'])
        ->setParameter(7, $m['INS_SIGLE']."-".$m['INS_NUMERO_DEPT'])
        ->setParameter(8, intval($m['PER_LICENCE']))
        ->getQuery()
        ->execute();
      }
    }

    /**
     * Creates a new joueur entity.
     *
     * @Route("/new", name="joueur_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $joueur = new Joueur();
        $form = $this->createForm('AppBundle\Form\JoueurType', $joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($joueur);
            $em->flush();

            return $this->redirectToRoute('joueur_show', array('id' => $joueur->getId()));
        }

        return $this->render('joueur/new.html.twig', array(
            'joueur' => $joueur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a joueur entity.
     *
     * @Route("/{id}", name="joueur_show")
     * @Method("GET")
     */
    public function showAction(Joueur $joueur)
    {
        $deleteForm = $this->createDeleteForm($joueur);
        $em = $this->getDoctrine()->getManager();
        $objDateLim = $em->getRepository('AppBundle:Config')->getDateLimite();

        if($objDateLim){
          $dateLimite = \DateTime::createFromFormat('d/m/Y',$objDateLim->getValue());
        }else{
          $dateLimite = null;
        }

        return $this->render('joueur/show.html.twig', array(
            'joueur' => $joueur,
            'delete_form' => $deleteForm->createView(),
            'dateLimite' => $dateLimite,
        ));
    }

    /**
     * Displays a form to edit an existing joueur entity.
     *
     * @Route("/{id}/edit", name="joueur_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Joueur $joueur)
    {
        $deleteForm = $this->createDeleteForm($joueur);
        $editForm = $this->createForm('AppBundle\Form\JoueurType', $joueur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            if (!$editForm->get('partenaireDH')->getData() && $editForm->get('DhId')->getData()){
              $partDH = $em->getRepository('AppBundle:Joueur')->find($editForm->get('DhId')->getData());
              $partDH->setDhId(null);
              $em->persist($partDH);
            }

            if (!$editForm->get('partenaireDD')->getData() && $editForm->get('DdId')->getData()){
              $partDD = $em->getRepository('AppBundle:Joueur')->find($editForm->get('DdId')->getData());
              $partDD->setDdId(null);
              $em->persist($partDD);
            }

            if (!$editForm->get('partenaireMX')->getData() && $editForm->get('MxId')->getData()){
              $partMX = $em->getRepository('AppBundle:Joueur')->find($editForm->get('MxId')->getData());
              $partMX->setMxId(null);
              $em->persist($partMX);
            }

            $em->flush();
            return $this->redirectToRoute('joueur_edit', array('id' => $joueur->getId()));
        }

        return $this->render('joueur/edit.html.twig', array(
            'joueur' => $joueur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a joueur entity.
     *
     * @Route("/{id}", name="joueur_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Joueur $joueur)
    {
        $form = $this->createDeleteForm($joueur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($joueur);
            $em->flush();
        }

        return $this->redirectToRoute('joueur_index');
    }

    /**
     * Creates a form to delete a joueur entity.
     *
     * @param Joueur $joueur The joueur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Joueur $joueur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('joueur_delete', array('id' => $joueur->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
