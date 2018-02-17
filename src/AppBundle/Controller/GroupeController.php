<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Groupe;
use AppBundle\Entity\Joueur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

/**
 * Groupe controller.
 *
 * @Route("groupe")
 */
class GroupeController extends Controller
{
    /**
     * Lists all groupe entities.
     *
     * @Route("/", name="groupe_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupes = $em->getRepository('AppBundle:Groupe')->findAll();

        $nbjoueurs = $em->getRepository('AppBundle:Joueur')->createQueryBuilder('j')
        ->select('count(j) as nb')
        ->join('j.groupes','g')
        ->orderBy('g.nom','ASC')
        ->groupBy("g.id")
        ->getQuery()
        ->getResult();

        return $this->render('groupe/index.html.twig', array(
            'groupes' => $groupes,
            'nbjoueurs' => $nbjoueurs,
        ));
    }

    /**
     * Finds and displays a groupe entity.
     *
     * @Route("/affecter", name="groupe_affecter")
     * @Method({"GET", "POST"})
     */
    public function affecterAction(Request $request)
    {
      $form = $this->createFormBuilder()
              ->add('tableaux', ChoiceType::class, array(
              'multiple' => true,
              'label' => "Choisir les tableaux",
              'choices'  => array(
                  'SH' => 'SH',
                  'SD' => 'SD',
                  'DH' => 'DH',
                  'DD' => 'DD',
                  'MX' => 'MX',
              )))
              ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $tableaux = $form->get('tableaux')->getData();
        if ( \in_array("SH",$tableaux)){
          $groupes = $em->getRepository('AppBundle:Groupe')->findSH();
          $joueurs = $em->getRepository('AppBundle:Joueur')->findSH();

          $this->doAffectation($groupes,$joueurs);
        }
        if ( \in_array("SD",$tableaux)){
          $groupes = $em->getRepository('AppBundle:Groupe')->findSD();
          $joueurs = $em->getRepository('AppBundle:Joueur')->findSD();

          $this->doAffectation($groupes,$joueurs);
        }
        if ( \in_array("DH",$tableaux)){
          $groupes = $em->getRepository('AppBundle:Groupe')->findDH();
          $joueurs = $em->getRepository('AppBundle:Joueur')->findPairesDH();

          $this->doAffectation($groupes,$joueurs,"DH");
        }
        if ( \in_array("DD",$tableaux)){
          $groupes = $em->getRepository('AppBundle:Groupe')->findDD();
          $joueurs = $em->getRepository('AppBundle:Joueur')->findPairesDD();

          $this->doAffectation($groupes,$joueurs,"DD");
        }
        if ( \in_array("MX",$tableaux)){
          $groupes = $em->getRepository('AppBundle:Groupe')->findMX();
          $joueurs = $em->getRepository('AppBundle:Joueur')->findPairesMX();

          $this->doAffectation($groupes,$joueurs,"MX");
        }
        return $this->redirectToRoute('joueur_index');
      }
      return $this->render('groupe/affecter.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    private function doAffectation($groupes=null,$joueurs=null,$tableau=null){
      if(!$joueurs || !$groupes) return;

      $em = $this->getDoctrine()->getManager();

      $joueursObj = new \ArrayObject( $joueurs );
      $iterator = $joueursObj->getIterator();

      foreach ($groupes as $groupe) {
        $em->persist($groupe);
        $groupe->removeAllJoueurs();
      }
      $em->persist($groupe);

      foreach ($groupes as $groupe) {
        $i=1;
        while ($i <= $groupe->getType()->getNbJoueurs()) {
          if (!$iterator->valid()) break;
          $joueur=$iterator->current();

          switch ($tableau) {
            case 'DH':
              $joueur = $joueur[0];
              $part = $joueur->getPartenaireDH();
              break;
            case 'DD':
              $joueur = $joueur[0];
              $part = $joueur->getPartenaireDD();
              break;
            case 'MX':
              $joueur = $joueur[0];
              $part = $joueur->getPartenaireMX();
              break;
            default:
              //do nothing
              $part = null;
              break;
          }

          if ( $joueur->getEstLA()
            || ($part && $part->getEstLA())){
            $iterator->next();
            continue;
          }

          $joueur->addGroupe($groupe);
          $groupe->addJoueur($joueur);
          if ($part){
            $part->addGroupe($groupe);
            $groupe->addJoueur($part);
            $em->persist($part);
          }
          $em->persist($joueur);
          $iterator->next();
          $i++;
        }

        $em->persist($groupe);
      }
      $em->flush();
    }

    /**
     * Creates a new groupe entity.
     *
     * @Route("/new", name="groupe_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $groupe = new Groupe();
        $form = $this->createForm('AppBundle\Form\GroupeType', $groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($groupe);
            $em->flush();

            return $this->redirectToRoute('groupe_show', array('id' => $groupe->getId()));
        }

        return $this->render('groupe/new.html.twig', array(
            'groupe' => $groupe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a groupe entity.
     *
     * @Route("/{id}", name="groupe_show")
     * @Method("GET")
     */
    public function showAction(Groupe $groupe)
    {
        $deleteForm = $this->createDeleteForm($groupe);

        return $this->render('groupe/show.html.twig', array(
            'groupe' => $groupe,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing groupe entity.
     *
     * @Route("/{id}/edit", name="groupe_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Groupe $groupe)
    {
        $deleteForm = $this->createDeleteForm($groupe);
        $editForm = $this->createForm('AppBundle\Form\GroupeType', $groupe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('groupe_edit', array('id' => $groupe->getId()));
        }

        return $this->render('groupe/edit.html.twig', array(
            'groupe' => $groupe,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a groupe entity.
     *
     * @Route("/{id}", name="groupe_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Groupe $groupe)
    {
        $form = $this->createDeleteForm($groupe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($groupe);
            $em->flush();
        }

        return $this->redirectToRoute('groupe_index');
    }

    /**
     * Creates a form to delete a groupe entity.
     *
     * @param Groupe $groupe The groupe entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Groupe $groupe)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('groupe_delete', array('id' => $groupe->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
