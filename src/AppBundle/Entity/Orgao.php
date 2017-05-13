<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Orgao
 *
 * @ORM\Table(name="orgao")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\orgaoRepository")
 */
class Orgao
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeOrgao", type="string", length=255)
     */
    private $nomeOrgao;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomeOrgao
     *
     * @param string $nomeOrgao
     *
     * @return orgao
     */
    public function setNomeOrgao($nomeOrgao)
    {
        $this->nomeOrgao = $nomeOrgao;

        return $this;
    }

/**
     * Set id
     *
     * @param int $idOrgao
     *
     * @return orgao
     */
    public function setId($idOrgao)
    {
        $this->id = $idOrgao;

        return $this;
    }


    /**
     * Get nomeOrgao
     *
     * @return string
     */
    public function getNomeOrgao()
    {
        return $this->nomeOrgao;
    }

   public function __contruct($idOrgao , $nomeOrgao) {

	$this->id = $idOrgao;
	$this->nomeOrgao = $nomeOrgao;
	echo $this->id;
	echo $this->nomeOrgao;
  }
}
