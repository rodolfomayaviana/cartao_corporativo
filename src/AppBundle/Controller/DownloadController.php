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
//      public function BuscaDadoAction($em) {

		$this->em = $this->getDoctrine()->getManager();

//		$this->em = $em;
		$this->gastoController = new GastoController($this->em);
		$this->portadorController = new PortadorController($this->em);
		$this->favorecidoController = new FavorecidoController($this->em);
		$this->orgaoController = new OrgaoController($this->em);
		$this->unidadeController = new UnidadeController($this->em);

		$this->baixaArquivo(2016 , 12 );
		$this->extraiZip(2016 , 12 );
		$this->trataRegistro ( 2016 , 12);

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
             //   $line = fgets($handle);
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

// Despreza registro com quantidade menor de campos - dados secretos

		if(substr($vector[12] , 0 , 3)  ==  "Inf") {
                        return;
                }

// Trata orgao superior

		$orgaoSuperior = $this->orgaoController->getOrgaoById($vector[0]);

		$nomeSemEspecial = strtr(utf8_decode($vector[1]),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');

		if ($orgaoSuperior == null) {
			$orgaoSuperior = $this->orgaoController->createOrgao($vector[0] , $nomeSemEspecial);

		}

// Trata orgao subordinado

		$orgaoSubordinado = $this->orgaoController->getOrgaoById($vector[2]);

		$nomeSemEspecial = strtr(utf8_decode($vector[3]),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');

                if ($orgaoSubordinado == null) {
                        $orgaoSubordinado = $this->orgaoController->createOrgao($vector[2] , $vector[3]);
		}

// Trata portador
		$nomeSemEspecial = strtr(utf8_decode($vector[9]),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');

		$portador = $this->portadorController->getPortadorByNome($nomeSemEspecial);

		if ($portador == null) {
			$portador = $this->portadorController->createPortador($nomeSemEspecial , $orgaoSubordinado);

		}

// Trata favorecido
// Saque nao vem com CNPJ do favorecido. Portanto, e desviado para o valor 1 (nao existe esse CNPJ ou CPF

		if (substr($vector[10] , 0 , 5)  == "SAQUE") {
			$vector[12] = 1;
		}
// Ha registros em que existe informacao do nome do proprietario, mas nao seu CPF. Nesse caso eh informado o cpf 2 para todos. Verificar regra

		if (strlen($vector[12]) == 0 ) {
			$vector[12] = 2;
		}
		$nomeSemEspecial = strtr(utf8_decode($vector[13]),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');

		$favorecido = $this->favorecidoController->getFavorecidoById($vector[12]);

                if ($favorecido === null) {
                        $favorecido = $this->favorecidoController->createFavorecido($vector[12] , $nomeSemEspecial);

		}

// Trata  Unidade gestora

                $unidadeGestora = $this->unidadeController->getUnidadeById($vector[4]);

		$nomeSemEspecial = strtr(utf8_decode($vector[5]),utf8_decode('ŠŒŽšœžŸ¥µÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝßàáâãäåæçèéêëìíîïðñòóôõöøùúûüýÿ'),'SOZsozYYuAAAAAAACEEEEIIIIDNOOOOOOUUUUYsaaaaaaaceeeeiiiionoooooouuuuyy');

		if ($unidadeGestora == null) {
			$unidadeGestora = $this->unidadeController->createUnidade($vector[4] , $nomeSemEspecial);
		}

		$valorTransacao = str_replace("," , "." , $vector[14]);

		$nomeSemEspecial = preg_replace("[^a-zA-Z0-9_]", "", strtr($vector[10], "áàãâéêíóôõúüçÁÀÃÂÉÊÍÓÔÕÚÜÇ ", "aaaaeeiooouucAAAAEEIOOOUUC_"));

         //       echo "superior" . $orgaoSuperior->getId();
         //       echo "subordinado" . $orgaoSubordinado->getId();
        //        echo "unidade" . $unidadeGestora->getId();
       //         echo "favorecido" . $favorecido->getId();
		$gasto = $this->gastoController->createGasto($orgaoSuperior , $orgaoSubordinado , $unidadeGestora , $vector[6] , $vector[7] , $portador , $nomeSemEspecial , $vector[11] , $favorecido , $valorTransacao);
    }

    public function __autoload ($classe) {
		include_once("Entity/".$classe."php");
    }
}



