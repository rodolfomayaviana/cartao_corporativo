<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Gasto;
class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
	$em = $this->getDoctrine()->getManager();
//	$repo = $em->getRepository('AppBundle:Gasto');
//	$array = $repo->findBy(array('orgaoSuperior' => '20000',));
//	echo $array[1];
	$qb = $em->createQueryBuilder('AppBundle:Gasto');
	$qb
	->addSelect('a')
	->from('AppBundle:Gasto', 'a');
//	->groupBy('AppBundle\Entity\Gasto.portador')
//	->orderBy('AppBundle\Entity\Gasto.totalTransacao', 'DESC');
	$result = $qb->getQuery()->getResult();
	var_dump($result);
//	$Gasto = new Gasto();
//	$query = $em->createQuery('select $portador, SUM($valorTransacao) from AppBundle:Gasto');
//	echo $query->getResult();

//	$qb->select('a.portador as portador', 'SUM(a.valorTransacao) as totalTransacao')->from('gasto' , 'a')->groupBy('a.portador');
//	$query = $qb->getQuery();
//	echo $query->getResult();

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
        ]);
    }
}
