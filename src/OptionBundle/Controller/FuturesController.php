<?php
/**
 * Author: Vehsamrak
 * Date Created: 14.02.16 16:17
 */

namespace OptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/futures")
 */
class FuturesController extends Controller
{

    /**
     * @Route("/")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('OptionBundle:Futures:index.html.twig', []);
    }
}
