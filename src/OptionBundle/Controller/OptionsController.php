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
 * @Route("/options")
 */
class OptionsController extends Controller
{

    /**
     * @Route("/{futuresCode}")
     * @return Response
     */
    public function indexAction(string $futuresCode): Response
    {
        $futuresRepository = $this->get('optionboard.futures_repository');
        $priceCollector = $this->get('optionboard.price_collector');

        $symbolCode = substr($futuresCode, 0, 2);
        $expirationMonthLetter = substr($futuresCode, 2, 1);

        $expirationMonth = $priceCollector->getMonthByLetter($expirationMonthLetter);
        $expirationYear = substr($futuresCode, 3, 2);

        $futures = $futuresRepository->findOneBySymbolAndExpirationMonthAndYear(
            $symbolCode,
            $expirationMonth,
            $expirationYear
        );

        $viewParameters = [];

        if ($futures) {
            $options = $this->get('optionboard.option_contract_repository')->findByFuturesAndOrderByStrike($futures);
            $viewParameters['options'] = $options;
        }

        return $this->render('OptionBundle:Futures:index.html.twig', $viewParameters);
    }
}
