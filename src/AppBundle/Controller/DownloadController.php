<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Controller\GastoController;
use AppBundle\Controller\OrgaoController;
use AppBundle\Controller\PortadorController;
use AppBundle\Controller\FavorecidoController;
use AppBundle\Controller\UnidadeController;

class DownloadController extends Controller
{
	private $gastoController;
	private $portadorController;
	private $favorecidoController;
	private $orgaoController;
	private $unidadeController;
	private $em;

    /**
     * @Route("/download", name="download")
     */
    public function BuscaDadoAction(Request $request) {

		$this->em = $this->getDoctrine()->getManager();

		$this->gastoController = new GastoController($this->em);
		$this->portadorController = new PortadorController($this->em);
		$this->favorecidoControlller = new FavorecidoController($this->em);
		$this->orgaoController = new OrgaoController($this->em);
		$this->unidadeController = new UnidadeController($this->em);

		$this->baixaArquivo(2016 , 03 );
		$this->extraiZip(2016 , 03 );
		$this->trataRegistro ( 2016 , 03);

		 return new Response (
                '<html><body>Banco de dados atualizado</body></html>');

    }


    public function baixaArquivo($ano , $mes) {

                $url = $this->container->getParameter('url_download');

                $url = substr_replace($url , str_pad($ano, 4, '0', STR_PAD_LEFT) , 61 , 4 );
                $url = substr_replace($url , str_pad($mes, 2, '0', STR_PAD_LEFT) , 68 , 2 );

		$zipFile = "archive/zipfile"  . str_pad($ano, 4, '0', STR_PAD_LEFT) . str_pad($mes, 2, '0', STR_PAD_LEFT) . ".zip";
		$zipResource = fopen($zipFile, "w");

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FAILONERROR, true);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_AUTOREFERER, true);
		curl_setopt($ch, CURLOPT_BINARYTRANSFER,true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_FILE, $zipResource);
		$page = curl_exec($ch);

		if(!$page) {
 			echo "Error :- ".curl_error($ch);
		}

	        curl_close($ch);

    }

    public function extraiZip($ano , $mes)  {

// Forma incorreta - verificar com o professor...

		system ('unzip -d archive archive/zipfile' . str_pad($ano, 4, '0', STR_PAD_LEFT) . str_pad($mes, 2, '0', STR_PAD_LEFT) . '.zip');

//		$zip = new ZipArchive64;
//        	$extractPath = "archive/";
//
//        	if($zip->open($zipFile) != "true"){
//                	echo "Error :- Unable to open the Zip File";
//        	}
//
//
//        	$zip->extractTo($extractPath);
//
//		$zip->close();
    }

    public function trataRegistro($ano , $mes) {

		$handle = fopen("archive/" . str_pad($ano, 4, '0', STR_PAD_LEFT) . str_pad($mes, 2, '0', STR_PAD_LEFT) . "_CPGF.csv", "r");
                $line = fgets($handle);
		if ($handle) {
			$line = fgets($handle);
			while (($line = fgets($handle)) !== false) {
                              $this->trataDados($line);
   		 	}

  		 	 fclose($handle);
		} else {
    			echo "Error :- Empty archive";
		}

    }

    public function trataDados($line) {

		$vector = explode ("	" , $line );

		$qtRegistros = count($vector);

		echo "Total de campos " . $qtRegistros;

// Despreza registro com quantidade menor de campos - dados secretos

		if( $qtRegistros != 15) {
                        return;
                }

// Trata orgao superior

		$orgaoSuperior = $this->OrgaoController->getOrgaoById($vector[0]);

		if $orgaoSuperior == null) {
			$orgaoSuperior = $this->OrgaoController->createOrgao($vector[0] , $vector[1]);
		}

// Trata orgao subordinado

		$orgaoSubordinado = $this->OrgaoController->getOrgaoById($vector[2]);

                if ($orgaoSubordinado == null) {
                        $orgaoSubordinado = $this->OrgaoController->createOrgao($vector[2] , $vector[3]);
                }

// Trata portador

		$portador = $this->PortadorController->getPortadorByName($vector[9]);

		if ($portador == null) {
			$this->PortadorController->createPortador($vector[9] , $orgaoSubordinado);
               }

// Trata favorecido

                $favorecido = $this->FavorecidoController->getFavorecidoById($vector[12]);

                if ($favorecido == null) {
                        $this->FavorecidoController->createFavorecido($vector[12] , $vector[13]);
               }

		$portador = $t ($vector[12] , $vector[13]);
		$em->persist($portador);
		echo "passou";
	        $favorecido = new Pessoa();
                $favorecido->setNomePessoa($vector[13]);
		$em->persist($favorecido);

		$orgaoSuperior = new Orgao();
		$orgaoSuperior->setNomeOrgao($vector[1]);
		$em->persist($orgaoSuperior);

		$orgaoSubordinado = new Orgao();
                $orgaoSubordinado->setNomeOrgao($vector[3]);
		$em->persist($orgaoSubordinado);

		$unidadeGestora = new UnidadeGestora();
                $unidadeGestora->setNomeUnidade($vector[5]);
		$em->persist($orgaoSubordinado);

		$gasto = new Gasto($em);
		$gasto->setOrgaoSuperior($orgaoSuperior);
		$gasto->setOrgaoSubordinado($orgaoSubordinado);
		$gasto->setUnidadeGestora($unidadeGestora);
		$gasto->setAnoExtrato($vector[6]);
		$gasto->setMesExtrato($vector[7]);
		$gasto->setPortador($portador);

		echo "ID portador ";
		echo  $portador->getId();
		echo "Nome portador "; 
		echo $portador->getNomePessoa();
		$gasto->setNomeTransacao($vector[10]);
		$gasto->setDataTransacao($vector[11]);
		$gasto->setFavorecido($favorecido);
//		$gasto->setValorTransacao($vector[14]);
		$gasto->setValorTransacao(100.00);
		$em->persist($gasto);
		$em->flush();
		echo "flushou!";
    }

    public function __autoload ($classe) {
		include_once("Entity/".$classe."php");
    }
}



