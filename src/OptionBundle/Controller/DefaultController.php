<?php

namespace OptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Vehsamrak
 * @Route("/")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="option_index")
     * @return Response
     */
    public function indexAction()
    {
        return $this->render('OptionBundle:Default:index.html.twig');
    }
}
