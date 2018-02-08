<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

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
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
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
        ->groupBy("j.estSimple")
        ->where('j.sexe = \'M\'')
        ->getQuery();

        $res4 = $q4->getResult();
        $shs = $res4[0]["nb"];

        $q4_2 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->groupBy("j.estSimple")
        ->where('j.sexe = \'F\'')
        ->getQuery();

        $res4_2 = $q4_2->getResult();
        $sds = $res4_2[0]["nb"];

        $q5 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->groupBy("j.estDouble")
        ->where('j.sexe = \'F\'')
        ->andWhere('j.partenaireDD IS NOT NULL')
        ->getQuery();

        $res5 = $q5->getResult();
        $dds = $res5[0]["nb"];

        $q6 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->groupBy("j.estDouble")
        ->where('j.sexe = \'M\'')
        ->andWhere('j.partenaireDH IS NOT NULL')
        ->getQuery();

        $res6 = $q6->getResult();
        $dhs = $res6[0]["nb"];

        $q7 = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->groupBy("j.estMixte")
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
}
