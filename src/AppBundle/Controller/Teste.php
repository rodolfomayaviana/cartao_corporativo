<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\FavorecidoController;


class TesteController extends Controller {
   /**
     * @Route("/teste", name="teste")
     */



        public function getFavorecidoById ($idfrSRF) {

		$favorecidoController =  new FavorecidoController( 59585 , "Rodolfo" );

		   return new Response (
	                '<html><body>Banco de dados atualizado</body></html>');

	}
}
