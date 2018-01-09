<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class LuckyController extends Controller
{
    /**
     * @Route("/lucky/number")
     */
    public function numberAction()
    {
        $number = mt_rand(0, 10);
        
        $a = 1;
        $b = 6;
        
        $c = $a + $b;

        return $this->render('lucky/number.html.twig', array(
            'number' => $number,
            'nom' => 'Jojo',
            'y' => $c,
        ));
    }
}
