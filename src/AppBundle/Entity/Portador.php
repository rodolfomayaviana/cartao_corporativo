<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Orgao;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Portador
 *
 * @ORM\Table(name="portador")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PortadorRepository")
 */
class Portador
{

    /**
     * @var string
     * @ORM\Column(name="nomePortador", type="string", length=255)
     * @ORM\Id
    */
    private $nomePortador;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Orgao", inversedBy="portadores")
     * @ORM\JoinColumn(name="orgao_id", referencedColumnName="id")
     */
    private $orgaoSubordinado;


    private $gastos;

     /**
     * Set orgaoSubordinado
     *
     * @param \stdClass $orgaoSubordinado
     *
     * @return Portador
     */
    public function setOrgaoSubordinado($orgaoSubordinado)
    {
        $this->orgaoSubordinado = $orgaoSubordinado;

        return $this;
    }

    /**
     * Get orgaoSubordinado
     *
     * @return \stdClass
     */
    public function getOrgaoSubordinado()
    {
        return $this->orgaoSubordinado;
    }

    /**
     * Set nomePortador
     *
     * @param string $nomePortador
     *
     * @return Portador
     */
    public function setNomePortador($nomePortador)
    {
        $this->nomePortador = $nomePortador;

        return $this;
    }

    /**
     * Get nomePortador
     *
     * @return string
     */
    public function getNomePortador()
    {
        return $this->nomePortador;
    }

    public function __construct()
    {
    	$this->gastos = new ArrayCollection();
    }

}

