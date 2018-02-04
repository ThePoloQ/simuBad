<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

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

        return $this->render('joueur/index.html.twig', array(
            'joueurs' => $joueurs,
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

        $joueurs = $em->getRepository('AppBundle:Joueur')->findBy(array("sexe"=>"M","estSimple"=> true),array("coteSimple"=>"DESC"));

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
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

        $joueurs = $em->getRepository('AppBundle:Joueur')->findBy(array("sexe"=>"F","estSimple"=> true),array("coteSimple"=>"DESC"));

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
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

        $q = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select('CONCAT(j.nom,\' / \',p.nom) as nom_equipe')
        ->addSelect('j.coteDouble + p.coteDouble as moyenne')
        ->addSelect('j.dateInscription as jDateInscription')
        ->addSelect('p.dateInscription as pDateInscription')
        ->join('j.partenaireDH', 'p')
        ->where('j.sexe = \'M\'')
        ->andWhere('j.estDouble = true')
        ->andWhere('j.id < p.id')
        ->orderBy('moyenne','DESC')
        ->getQuery();

        $equipes = $q->getResult();
        return $this->render('joueur/equipes.html.twig', array(
            'equipes' => $equipes,
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

        $q = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select('CONCAT(j.nom,\' / \',p.nom) as nom_equipe')
        ->addSelect('j.coteDouble + p.coteDouble as moyenne')
        ->addSelect('j.dateInscription as jDateInscription')
        ->addSelect('p.dateInscription as pDateInscription')
        ->join('j.partenaireDD', 'p')
        ->where('j.sexe = \'F\'')
        ->andWhere('j.estDouble = true')
        ->andWhere('j.id < p.id')
        ->orderBy('moyenne','DESC')
        ->getQuery();

        $equipes = $q->getResult();
        return $this->render('joueur/equipes.html.twig', array(
            'equipes' => $equipes,
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

        $q = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select('CONCAT(j.nom,\' / \',p.nom) as nom_equipe')
        ->addSelect('j.coteMixte + p.coteMixte as moyenne')
        ->addSelect('j.dateInscription as jDateInscription')
        ->addSelect('p.dateInscription as pDateInscription')
        ->join('j.partenaireMX', 'p')
        ->where('j.sexe = \'M\'')
        ->andWhere('j.estMixte = true')
        ->orderBy('moyenne','DESC')
        ->getQuery();

        $equipes = $q->getResult();
        return $this->render('joueur/equipes.html.twig', array(
            'equipes' => $equipes,
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

        $joueurs = $em->getRepository('AppBundle:Joueur')->findBy(array("sexe"=>"M","estDouble"=> true,"partenaireDH" => null));

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
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

        $joueurs = $em->getRepository('AppBundle:Joueur')->findBy(array("sexe"=>"F","estDouble"=> true,"partenaireDD" => null));

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
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

        $joueurs = $em->getRepository('AppBundle:Joueur')->findBy(array("estMixte"=> true,"partenaireMX" => null));

        return $this->render('joueur/liste.html.twig', array(
            'joueurs' => $joueurs,
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
              ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $file = $form->get('submitFile');
        $upFile=$file->getData();
        if(in_array($upFile->getMimeType(),array("text/plain","text/csv"))){
            $rows = str_getcsv(file_get_contents($upFile->getPathname()), "\n");
            /*
            *  Nom_0;Licence_1;Sexe_2;Date_3;Simple_4;Double_5;Doubl_6;L_7;Mixte_8;Mixte_9;L_10
            */
            foreach($rows as $key => $row){
              if ($key == 0) continue;
              $valeurs = str_getcsv($row,";");
              $joueur = $em->getRepository('AppBundle:Joueur')->findOneBy(array("licence" => $valeurs[1]));
              if (!$joueur) {
                $joueur = New Joueur();
                $joueur->setLicence($valeurs[1]);
              }
              $joueur->setNom($valeurs[0]);
              $joueur->setSexe($valeurs[2]);
              $joueur->setDateInscription(\DateTime::createFromFormat('d/m/Y', $valeurs[3]));

              if($valeurs[4]!="")
                $joueur->setEstSimple(true);

              if($valeurs[5]!=""){
                $joueur->setEstDouble(true);
                if($valeurs[7]!=""){
                  $part = $em->getRepository('AppBundle:Joueur')->findOneBy(array("licence" => $valeurs[7]));
                  if($part && $valeurs[2] == "M"){
                    $joueur->setPartenaireDH($part);
                  }elseif($part && $valeurs[2] == "F"){
                    $joueur->setPartenaireDD($part);
                  }
                }
              }
              if($valeurs[8]!=""){
                $joueur->setEstMixte(true);
                if($valeurs[10]!=""){
                  $part = $em->getRepository('AppBundle:Joueur')->findOneBy(array("licence" => $valeurs[10]));
                  if($part){
                    $joueur->setPartenaireMX($part);
                  }
                }
              }

              $em->persist($joueur);
              $em->flush();
            }
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
                  '' => null,
                  'Yes' => true,
              )))
              ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        if ($form->get('maj')->getData() == true){
          $em = $this->getDoctrine()->getManager();
          $joueurs = $em->getRepository('AppBundle:Joueur')
          ->createQueryBuilder('j')
          ->select('j.licence as licence')
          ->setMaxResults(250)
          ->getQuery()
          ->getResult();
          $licences = array();
          foreach ($joueurs as $j) {
            $licences[] = sprintf("%'.08d", $j["licence"]);
          }
          $sDate = $form->get('date')->getData()->format('Y-m-d');
          $url=$this->getParameter('ffbad_url').'?AuthJson={"Login":"'.$this->getParameter('ffbad_login').'","Password":"'.$this->getParameter('ffbad_password').'"}&QueryJson={"Function":"ws_getrankingallbyarrayoflicencedate","Param":{"Param1":'.json_encode($licences).',"Param2":"'.$sDate.'"}}';
          $output=file_get_contents($url);
          $res = json_decode($output,true);
          $moyennes = $res["Retour"];
          foreach ($moyennes as $m) {
            $em->createQueryBuilder()
            ->update('AppBundle:Joueur','j')
            ->set('j.coteSimple','?1')
            ->set('j.coteDouble','?2')
            ->set('j.coteMixte','?3')
            ->where('j.licence = ?4')
            ->setParameter(1, $m['SIMPLE_COTE_FFBAD'])
            ->setParameter(2, $m['DOUBLE_COTE_FFBAD'])
            ->setParameter(3, $m['MIXTE_COTE_FFBAD'])
            ->setParameter(4, intval($m['PER_LICENCE']))
            ->getQuery()
            ->execute();
          }
          return $this->redirectToRoute('joueur_index');
        };
       }

      return $this->render('joueur/moyenne.html.twig', array(
          'form' => $form->createView(),
      ));
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

        return $this->render('joueur/show.html.twig', array(
            'joueur' => $joueur,
            'delete_form' => $deleteForm->createView(),
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
