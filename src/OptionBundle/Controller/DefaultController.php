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

        $priceCollector->saveOptionPrices($symbol, (int) (new \DateTime('2016-03-01'))->format('n'));
        $priceCollector->saveOptionPrices($symbol, (int) (new \DateTime('2016-04-01'))->format('n'));
        $priceCollector->saveOptionPrices($symbol, (int) (new \DateTime('2016-05-01'))->format('n'));

        return $this->render('OptionBundle:Default:index.html.twig');
    }
}
