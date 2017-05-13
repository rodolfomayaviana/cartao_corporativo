<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Favorecido;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class FavorecidoController extends Controller {

	private $em;

        public function __construct ($em) {

		$this->em = $em;
        	return;
	}

	public function createFavorecido($idfrSRF , $nomeFavorecido )  {

		$favorecido = new Favorecido( $idfrSRF , $nomeFavorecido);


		$this->em->persist($favorecido);
                $this->em->flush();
	}

	public function getFavorecidoById ($idfrSRF) {

		$favorecido =  $this->em->getRepository('AppBundle:Favorecido')->find($idfrSRF);
		return $favorecido;
	}
}
