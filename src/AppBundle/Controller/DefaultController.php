<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\Gasto;
use Appbundle\Entity\Portador;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Query\ResultSetMapping;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
	$em = $this->getDoctrine()->getManager();
	$rsm = new  ResultSetMapping();
	$rsm-> addEntityResult('AppBundle\Entity\Gasto', 'g');
	$rsm-> addFieldResult('g', 'portador_nome', 'nomePortador');
        $rsm-> addFieldResult('g', 'valorTransacao', 'valorTransacao');
	$rsm-> addMetadataParameterMapping('nomePortador' , 'nomePortador');

	$query = $em->createNativeQuery('SELECT  g.portador_nome , g.valorTransacao FROM gasto g GROUP BY g.portador_nome', $rsm);
	$gastos = $query->getResult();
	var_dump($gastos);
//	$repo = $em->getRepository('AppBundle:Gasto');
//	$array = $repo->findBy(array('orgaoSuperior' => '20000',));
//	echo $array[1];
//	$qb = $em->createQueryBuilder('AppBundle:Gasto');
//	$qb
//	->addSelect('a')
//	->from('AppBundle:Gasto', 'a');
//	->groupBy('AppBundle\Entity\Gasto.portador')
//	->orderBy('AppBundle\Entity\Gasto.totalTransacao', 'DESC');
//	$result = $qb->getQuery()->getResult();
//	var_dump($result);
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
