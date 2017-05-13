<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Orgao;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class OrgaoController extends Controller {

	private $em;

        public function __construct ($em) {

		$this->em = $em;
        	return;
	}

	public function createOrgao($idOrgao , $nomeOrgao )  {

		$Orgao = new Orgao($idOrgao , $nomeOrgao);
		$Orgao->setNomeOrgao($nomeOrgao);
		$Orgao->setId($idOrgao);
		$this->em->persist($Orgao);
                $this->em->flush();
	}

	public function getOrgaoById ($idOrgao) {

		$orgao =  $this->em->getRepository('AppBundle:Orgao')->find($idOrgao);
		return $orgao;
	}
}
