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
 * @Route("/")
 */
class DefaultController extends Controller
{

    /**
     * @Route("/")
     * @return Response
     */
    public function indexAction()
    {
        $futuresRepository = $this->get('optionboard.futures_repository');
        $futures = $futuresRepository->findAll();

        return $this->render('OptionBundle:Default:index.html.twig', [
            'futuresList' => $futures,
        ]);
    }
}
