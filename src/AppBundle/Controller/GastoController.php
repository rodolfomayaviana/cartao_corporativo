<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\gasto;
use AppBundle\Entity\orgao;
use AppBundle\Entity\pessoa;
use AppBundle\Entity\unidadeGestora;


class GastoController extends Controller
{
    /**
     * @Route("/busca_dado", name="busca_dado")
     */
    public function BuscaDadoAction(Request $request)
    {

		$url = "http://arquivos.portaldatransparencia.gov.br/downloads.asp?a=2017&m=01&consulta=CPGF";
		$zipFile = "archive/zipfile.zip";
		$zipResource = fopen($zipFile, "w");
	// Get The Zip File From Server
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

		$this->trataRegistro();
	// $this->extraiZip();

	return new Response (
		'<html><body>Banco de dados atualizado</body></html>');
    }

	public function extraiZip()  {
		$zip = new ZipArchive;
        	$extractPath = "archive/";

        	if($zip->open($zipFile) != "true"){
                	echo "Error :- Unable to open the Zip File";
        	}

       	 /* Extract Zip File */
        	$zip->extractTo($extractPath);

		$zip->close();
		}

	public function trataRegistro() {

		$handle = fopen("archive/201701_CPGF.csv", "r");
                $line = fgets($handle);
		if ($handle) {
			$line = fgets($handle);
			while (($line = fgets($handle)) !== false) {
                              $this->criaGasto($line);
   		 	}

  		 	 fclose($handle);
		} else {
    	// error opening the file.
		}

	}

	public function criaGasto($line) {
		$vector = explode ("	" , $line );

		$em = $this->getDoctrine()->getManager();

		$portador = new pessoa();
		$portador->setNomePessoa($vector[9]);
		$em->persist($portador);

	        $favorecido = new pessoa();
                $favorecido->setNomePessoa($vector[13]);
		$em->persist($favorecido);

		$orgaoSuperior = new orgao();
		$orgaoSuperior->setNomeOrgao($vector[1]);
		$em->persist($orgaoSuperior);

		$orgaoSubordinado = new orgao();
                $orgaoSubordinado->setNomeOrgao($vector[3]);
		$em->persist($orgaoSubordinado);

		$unidadeGestora = new unidadeGestora();
                $unidadeGestora->setNomeUnidade($vector[5]);
		$em->persist($orgaoSubordinado);

		$gasto = new gasto();
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



