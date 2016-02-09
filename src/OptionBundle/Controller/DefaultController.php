<?php

namespace OptionBundle\Controller;

use Doctrine\ORM\EntityManager;
use OptionBundle\Entity\Futures;
use OptionBundle\Entity\Symbol;
use OptionBundle\Enum\SymbolCode;
use OptionBundle\Service\PriceCollector;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $symbol = $this->get('optionboard.symbol_repository')->findOneBySymbol(SymbolCode::CRUDE_OIL_WTI);
        $priceCollector = $this->get('optionboard.price_collector');

        $priceCollector->saveOptionPrices($symbol, (int) 3);
        $priceCollector->saveOptionPrices($symbol, (int) 4);
        $priceCollector->saveOptionPrices($symbol, (int) 5);

        return $this->render('OptionBundle:Default:index.html.twig');
    }
}
