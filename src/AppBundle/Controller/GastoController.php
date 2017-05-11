<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use ZipArchive;

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
                              $this->criaProduto($line);
   		 	}

  		 	 fclose($handle);
		} else {
    	// error opening the file.
		}

	}

	public function criaProduto($line) {
		echo $line;
		$vector = explode ("	" , $line );
		$gasto = new gasto();
		$orgaoSuperior = new orgao();
		echo $vector[0];
//		$orgaoSuperior->setNome(vector[1]);
	}
}



