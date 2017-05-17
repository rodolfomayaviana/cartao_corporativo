<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gasto
 *
 * @ORM\Table(name="gasto")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\gastoRepository")
 */
class Gasto
{
    /**
    * @var int
    * @ORM\Column(name="id", type="integer")
    * @ORM\Id
    * @ORM\GeneratedValue(strategy="AUTO")
    */
    private $id;

    /**
     * @var \stdClass
     * @ORM\ManyToOne(targetEntity="Orgao", inversedBy="orgaosSuperiores")
     * @ORM\JoinColumn(name="orgaoSuperior_id", referencedColumnName="id")
     */
    private $orgaoSuperior;

    /**
     * @var
     * @ORM\ManyToOne(targetEntity="Orgao", inversedBy="orgaosSubordinados")
     * @ORM\JoinColumn(name="orgaoSubordinado_id", referencedColumnName="id")
     */

    private $orgaoSubordinado;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="UnidadeGestora", inversedBy="gastos")
     * @ORM\JoinColumn(name="unidadeGestora_id", referencedColumnName="id")
     */
    private $unidadeGestora;

    /**
     * @var int
     *
     * @ORM\Column(name="anoExtrato", type="smallint")
     */
    private $anoExtrato;

    /**
     * @var int
     *
     * @ORM\Column(name="mesExtrato", type="smallint")
     */
    private $mesExtrato;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Portador", inversedBy="gastos")
     * @ORM\JoinColumn(name="portador_nome", referencedColumnName="nomePortador")
     */
    private $portador;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeTransacao", type="string", length=255)
     */
    private $nomeTransacao;

    /**
     * @var \stdClass
     *
     * @ORM\Column(name="dataTransacao", type="object")
     */
    private $dataTransacao;

    /**
     * @var \stdClass
     *
     * @ORM\ManyToOne(targetEntity="Favorecido", inversedBy="gastos")
     * @ORM\JoinColumn(name="favorecido_id", referencedColumnName="id")
     */

    private $favorecido;

    /**
     * @var string
     *
     * @ORM\Column(name="valorTransacao", type="decimal", precision=10, scale=2)
     */
    private $valorTransacao;


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
     * Set orgaoSuperior
     *
     * @param \stdClass $orgaoSuperior
     *
     * @return gasto
     */
    public function setOrgaoSuperior($orgaoSuperior)
    {
        $this->orgaoSuperior = $orgaoSuperior;

        return $this;
    }

    /**
     * Get orgaoSuperior
     *
     * @return \stdClass
     */
    public function getOrgaoSuperior()
    {
        return $this->orgaoSuperior;
    }

    /**
     * Set orgaoSubordinado
     *
     * @param \stdClass $orgaoSubordinado
     *
     * @return gasto
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
     * Set unidadeGestora
     *
     * @param \stdClass $unidadeGestora
     *
     * @return gasto
     */
    public function setUnidadeGestora($unidadeGestora)
    {
        $this->unidadeGestora = $unidadeGestora;

        return $this;
    }

    /**
     * Get unidadeGestora
     *
     * @return \stdClass
     */
    public function getUnidadeGestora()
    {
        return $this->unidadeGestora;
    }

    /**
     * Set anoExtrato
     *
     * @param integer $anoExtrato
     *
     * @return gasto
     */
    public function setAnoExtrato($anoExtrato)
    {
        $this->anoExtrato = $anoExtrato;

        return $this;
    }

    /**
     * Get anoExtrato
     *
     * @return int
     */
    public function getAnoExtrato()
    {
        return $this->anoExtrato;
    }

    /**
     * Set mesExtrato
     *
     * @param integer $mesExtrato
     *
     * @return gasto
     */
    public function setMesExtrato($mesExtrato)
    {
        $this->mesExtrato = $mesExtrato;

        return $this;
    }

    /**
     * Get mesExtrato
     *
     * @return int
     */
    public function getMesExtrato()
    {
        return $this->mesExtrato;
    }

    /**
     * Set portador
     *
     * @param \stdClass $portador
     *
     * @return gasto
     */
    public function setPortador($portador)
    {
        $this->portador = $portador;

        return $this;
    }

    /**
     * Get portador
     *
     * @return \stdClass
     */
    public function getPortador()
    {
        return $this->portador;
    }

    /**
     * Set nomeTransacao
     *
     * @param string $nomeTransacao
     *
     * @return gasto
     */
    public function setNomeTransacao($nomeTransacao)
    {
        $this->nomeTransacao = $nomeTransacao;

        return $this;
    }

    /**
     * Get nomeTransacao
     *
     * @return string
     */
    public function getNomeTransacao()
    {
        return $this->nomeTransacao;
    }

    /**
     * Set dataTransacao
     *
     * @param \stdClass $dataTransacao
     *
     * @return gasto
     */
    public function setDataTransacao($dataTransacao)
    {
        $this->dataTransacao = $dataTransacao;

        return $this;
    }

    /**
     * Get dataTransacao
     *
     * @return \stdClass
     */
    public function getDataTransacao()
    {
        return $this->dataTransacao;
    }

    /**
     * Set favorecido
     *
     * @param \stdClass $favorecido
     *
     * @return gasto
     */
    public function setFavorecido($favorecido)
    {
        $this->favorecido = $favorecido;

        return $this;
    }

    /**
     * Get favorecido
     *
     * @return \stdClass
     */
    public function getFavorecido()
    {
        return $this->favorecido;
    }

    /**
     * Set valorTransacao
     *
     * @param string $valorTransacao
     *
     * @return gasto
     */
    public function setValorTransacao($valorTransacao)
    {
        $this->valorTransacao = $valorTransacao;

        return $this;
    }

    /**
     * Get valorTransacao
     *
     * @return string
     */
    public function getValorTransacao()
    {
        return $this->valorTransacao;
    }
}
