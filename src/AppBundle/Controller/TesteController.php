<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Controller\FavorecidoController;
use Symfony\Component\HttpFoundation\Response;

class TesteController extends Controller {
   /**
     * @Route("/teste", name="teste")
     */


        public function TesteAction () {

		$ano = 2018;
		$mes = 12;
//		echo str_pad($ano, 4, '0', STR_PAD_LEFT);
//		echo str_pad($mes, 2, '0', STR_PAD_LEFT);
//		echo substr($ano , 0 , -3 );
//		echo substr($mes , -1 , 2 );
                $string = "archive/zipfile"  . $ano . $mes . ".zip";
		echo $string;
                $url = $this->container->getParameter('url_download');

                $url = substr_replace($url , str_pad($ano, 4, '0', STR_PAD_LEFT) , 61 , 4 );
                $url = substr_replace($url , str_pad($mes, 2, '0', STR_PAD_LEFT) , 68 , 2 );

		echo $url;
//		$em =  $this->getDoctrine()->getManager();


//		$url = $this->container->getParameter('url_download');
//		echo $url;
//		$unidadeController =  new UnidadeController($em);
//	        $unidadeController->createUnidade ( 12378 , "teste");
	//	$orgao = $OrgaoController->getOrgaoById(12378);
	//	$PortadorController = new PortadorController($em);
	//	$portador = $PortadorController->createPortador ("Rodolfo" , $orgao);
	//	$retorno = $PortadorController->getPortadorByNome ("Rodolfo");
	//	echo $retorno->getNomePortador();
	//	echo $retorno->getOrgaoSubordinado()->getNomeOrgao();
	//	return new Response ((string)$retorno);
                return new Response ('<html><body>Gravou</body></html>');
	}
}
