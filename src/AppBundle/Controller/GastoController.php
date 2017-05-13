<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Portador;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class GastoController extends Controller {

	private $em;

        public function __construct ($em) {

		$this->em = $em;
        	return;
	}

	public function createGasto($orgaoSuperior, $orgaoSubordinado, $unidadeGestora, $anoExtrato, $mesExtrato, $portador, $nomeTransacao, $dataTransacao, $favorecido, $valorTransacao )  {

		$Gasto = new Gasto();
		$Gasto->setOrgaoSuperior($orgaoSuperior);
		$Gasto->setOrgaoSubordinado($orgaoSubordinado);
                $Gasto->setUnidadeGestora($unidadeGestora);
                $Gasto->setAnoExtrato($anoExtrato);
                $Gasto->setMesExtrato($mesExtrato);
                $Gasto->setPortador($portador);
                $Gasto->setNomeTransacao($nomeTransacao);
                $Gasto->setDataTransacao($dataTransacao);
                $Gasto->setFavorecido($favorecido);
                $Gasto->setValorTransacao($valorTransacao);

		$this->em->persist($Portador);
                $this->em->flush();
	}

	public function getGastoById ($idGasto) {

		$gasto =  $this->em->getRepository('AppBundle:Gasto')->find($idGasto);
		return $gasto;
	}
}
