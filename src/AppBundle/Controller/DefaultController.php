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
        $q = $em->getRepository('AppBundle:Joueur')
        ->createQueryBuilder('j')
        ->select("COUNT(1) as nb")
        ->addSelect("j.dateInscription as date")
        ->groupBy("j.dateInscription")
        ->orderBy('j.dateInscription','ASC')
        ->getQuery();

        $res = $q->getResult();
        /*
        [
    			{ x: 10, y: 10 },
    			{ x: 20, y: 14 },
    			{ x: 30, y: 18 },
    			{ x: 40, y: 22 },
    			{ x: 50, y: 18 },
    			{ x: 60, y: 28 }
    		]*/
        $data1 = array();
        foreach ($res as $row) {
          $date = $row['date'];
          $data1[] = array( "label" => $date->format('d-M'), "y" => \intval($row['nb']));
        }

        echo '<pre>';
        //var_dump(json_encode($data1));
        echo '</pre>';
        //die();

        return $this->render('dashboard.html.twig', array(
            'data1' => $data1,
        ));
    }
}
