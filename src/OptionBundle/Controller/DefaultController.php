<?php

namespace OptionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @author Vehsamrak
 * @Route("/")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/", name="option_index")
     * @return RedirectResponse
     */
    public function indexAction()
    {
        return $this->redirectToRoute('option_trades_list');
    }
}
