<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Joueur;
use AppBundle\Entity\Type;
use AppBundle\Entity\Salle;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('index.html.twig');
    }

    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request, AuthenticationUtils $authUtils)
    {
        // get the login error if there is one
        $error = $authUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authUtils->getLastUsername();

        return $this->render('login.html.twig', array(
            'last_username' => $lastUsername,
            'error'         => $error,
        ));
    }

    /**
     * @Route("/user/init", name="init_user")
     */
    public function initUserAction(Request $request)
    {
      $form = $this->createFormBuilder()
              ->add('password', PasswordType::class, array(
                'label' => "Mot de Passe",
                'required' => true,
              ))
              ->getForm();
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        if ($form->get('password')->getData() == $this->getParameter('bclpassword')){
          $em = $this->getDoctrine()->getManager();

          $user = new User();
          $user->setUsername("$this->getParameter('bcluser')");
          $password = $passwordEncoder->encodePassword($user, $this->getParameter('bclpassword'));
          $user->setPassword($password);

          $em->persist($user);
          $em->flush();

          return $this->render('index.html.twig', array(
              'message' => "Utilisateur créé",
          ));
        };
       }

      return $this->render('user.html.twig', array(
          'form' => $form->createView(),
      ));
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $q0 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->getQuery();
        $res0 = $q0->getResult();
        $nbj = $res0[0]["nb"];

        if ($nbj < 1){
          return $this->render('index.html.twig',array(
            'message' => 'ERREUR - Aucun joueur dans la base'
          ));
        }

        $q1 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->addSelect("j.dateInscription as date")
        ->groupBy("j.dateInscription")
        ->orderBy('j.dateInscription','ASC')
        ->getQuery();

        $res1 = $q1->getResult();

        $q2 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->addSelect("j.club as club")
        ->groupBy("j.club")
        ->orderBy('nb','ASC')
        ->getQuery();

        $res2 = $q2->getResult();

        $q3 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->addSelect("j.sexe as sexe")
        ->groupBy("j.sexe")
        ->orderBy('nb','DESC')
        ->getQuery();

        $res3 = $q3->getResult();

        $q4 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->where('j.sexe = \'M\'')
        ->andWhere('j.estSimple = 1')
        ->getQuery();

        $res4 = $q4->getResult();
        $shs = $res4[0]["nb"];

        $q4_2 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->where('j.sexe = \'F\'')
        ->andWhere('j.estSimple = 1')
        ->getQuery();

        $res4_2 = $q4_2->getResult();
        $sds = $res4_2[0]["nb"];

        $q5 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->where('j.sexe = \'F\'')
        ->andWhere('j.partenaireDD IS NOT NULL')
        ->getQuery();

        $res5 = $q5->getResult();
        $dds = $res5[0]["nb"];

        $q6 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->where('j.sexe = \'M\'')
        ->andWhere('j.partenaireDH IS NOT NULL')
        ->getQuery();

        $res6 = $q6->getResult();
        $dhs = $res6[0]["nb"];

        $q7 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->where('j.partenaireMX IS NOT NULL')
        ->getQuery();

        $res7 = $q7->getResult();
        $mxs = $res7[0]["nb"];

        $data1 = array();
        foreach ($res1 as $row) {
          $date = $row['date'];
          $data1[] = array( "label" => $date->format('d-M'), "y" => \intval($row['nb']));
        }

        $data2 = array();
        foreach ($res2 as $row) {
          $data2[] = array( "label" => $row['club'], "y" => \intval($row['nb']));
        }

        $data3 = array();
        foreach ($res3 as $row) {
          $data3[] = array( "indexLabel" => $row['sexe'], "y" => \intval($row['nb']));
        }

        $data4 = array();
        $data4[] = array( "indexLabel" => "DH paires", "y" => (\intval($dhs)/2));
        $data4[] = array( "indexLabel" => "SD", "y" => \intval($sds));
        $data4[] = array( "indexLabel" => "SH", "y" => \intval($shs));
        $data4[] = array( "indexLabel" => "DD paires", "y" => (\intval($dds)/2));
        $data4[] = array( "indexLabel" => "MX paires", "y" => (\intval($mxs)/2));

        return $this->render('dashboard.html.twig', array(
            'data1' => $data1, //inscrits par date
            'data2' => $data2, //inscrits par club
            'data3' => $data3, //repartition M/F
            'data4' => $data4, //repartition Tableaux
        ));
    }

    /**
     * @Route("/init", name="init")
     */
    public function initAction(Request $request)
    {
      $em = $this->getDoctrine()->getManager();

      $q0 = $em->getRepository('AppBundle:Type')
      ->createQueryBuilder('t')
      ->select("COUNT(1) as nb")
      ->getQuery();
      $res0 = $q0->getResult();
      $nbT = $res0[0]["nb"];

      $q1 = $em->getRepository('AppBundle:Salle')
      ->createQueryBuilder('s')
      ->select("COUNT(1) as nb")
      ->getQuery();
      $res1 = $q0->getResult();
      $nbS = $res0[0]["nb"];

      $message = null;

      if ($nbT < 5){
        $t1= new Type();
        $t1->setNom("2x3");
        $t1->setNombrePoules(2);
        $t1->setTaillePoule(3);

        $t2= new Type();
        $t2->setNom("2x4");
        $t2->setNombrePoules(2);
        $t2->setTaillePoule(4);

        $t3= new Type();
        $t3->setNom("4x3");
        $t3->setNombrePoules(4);
        $t3->setTaillePoule(3);

        $t4= new Type();
        $t4->setNom("4x4");
        $t4->setNombrePoules(4);
        $t4->setTaillePoule(4);

        $t5= new Type();
        $t5->setNom("8x3");
        $t5->setNombrePoules(8);
        $t5->setTaillePoule(3);

        $em->persist($t1);
        $em->persist($t2);
        $em->persist($t3);
        $em->persist($t4);
        $em->persist($t5);

        $message = "Ajout des Types";
      }

      if ($nbS < 7){
        $s1= new Salle();
        $s1->setNom("Lezennes Samedi Simples");
        $s1->setNombreTerrains(8);
        $s1->setHeureDebut(\DateTime::createFromFormat('H:i','08:00'));
        $s1->setHeureFin(\DateTime::createFromFormat('H:i','17:00'));

        $s1_2= new Salle();
        $s1_2->setNom("Lezennes Samedi Mixte");
        $s1_2->setNombreTerrains(8);
        $s1_2->setHeureDebut(\DateTime::createFromFormat('H:i','18:00'));
        $s1_2->setHeureFin(\DateTime::createFromFormat('H:i','21:00'));

        $s2= new Salle();
        $s2->setNom("Lezennes Dimanche");
        $s2->setNombreTerrains(8);
        $s2->setHeureDebut(\DateTime::createFromFormat('H:i','08:00'));
        $s2->setHeureFin(\DateTime::createFromFormat('H:i','17:00'));

        $s2_2= new Salle();
        $s2_2->setNom("Lezennes Dimanche Phases Finales");
        $s2_2->setNombreTerrains(8);
        $s2_2->setHeureDebut(\DateTime::createFromFormat('H:i','17:00'));
        $s2_2->setHeureFin(\DateTime::createFromFormat('H:i','21:00'));

        $s3= new Salle();
        $s3->setNom("Hellemmes Samedi Simples");
        $s3->setNombreTerrains(7);
        $s3->setHeureDebut(\DateTime::createFromFormat('H:i','08:00'));
        $s3->setHeureFin(\DateTime::createFromFormat('H:i','17:00'));

        $s3_2= new Salle();
        $s3_2->setNom("Hellemmes Samedi Mixte");
        $s3_2->setNombreTerrains(7);
        $s3_2->setHeureDebut(\DateTime::createFromFormat('H:i','18:00'));
        $s3_2->setHeureFin(\DateTime::createFromFormat('H:i','21:00'));

        $s4= new Salle();
        $s4->setNom("Hellemmes Dimanche");
        $s4->setNombreTerrains(7);
        $s4->setHeureDebut(\DateTime::createFromFormat('H:i','08:00'));
        $s4->setHeureFin(\DateTime::createFromFormat('H:i','16:00'));

        $em->persist($s1);
        $em->persist($s1_2);
        $em->persist($s2);
        $em->persist($s2_2);
        $em->persist($s3);
        $em->persist($s3_2);
        $em->persist($s4);

        if (!$message){
          $message = "Ajout des Salles";
        }else{
          $message .= " & Ajout des Salles";
        }

      }

      if (!$message){
        $message = 'ERREUR - Types et Salles déjà existants';
      }else{
        $message = 'SUCCES - '.$message;
      }

      $em->flush();

      return $this->render('index.html.twig',array(
        'message' => $message,
      ));
    }
}
