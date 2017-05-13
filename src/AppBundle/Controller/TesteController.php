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

		$em =  $this->getDoctrine()->getManager();
	//	$OrgaoController =  new OrgaoController($em);
	//        $OrgaoController->createOrgao ( 12378 , "teste");
	//	$orgao = $OrgaoController->getOrgaoById(12378);
		$PortadorController = new PortadorController($em);
	//	$portador = $PortadorController->createPortador ("Rodolfo" , $orgao);
		$retorno = $PortadorController->getPortadorByNome ("Rodolfo");
		echo $retorno->getNomePortador();
		echo $retorno->getOrgaoSubordinado()->getNomeOrgao();
		return new Response ((string)$retorno);
//                return new Response ('<html><body>Gravou</body></html>');
	}
}
