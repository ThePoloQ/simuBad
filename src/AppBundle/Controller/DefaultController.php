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

        return $this->render('dashboard.html.twig', array(
            'data1' => $data1,
            'data2' => $data2,
            'data3' => $data3,
        ));
    }
}
