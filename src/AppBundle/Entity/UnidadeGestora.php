<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UnidadeGestora
 *
 * @ORM\Table(name="unidade_gestora")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\unidadeGestoraRepository")
 */
class UnidadeGestora
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nomeUnidade", type="string", length=255)
     */
    private $nomeUnidade;


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
     * Set nomeUnidade
     *
     * @param string $nomeUnidade
     *
     * @return unidadeGestora
     */
    public function setNomeUnidade($nomeUnidade)
    {
        $this->nomeUnidade = $nomeUnidade;

        return $this;
    }

    /**
     * Get nomeUnidade
     *
     * @return string
     */
    public function getNomeUnidade()
    {
        return $this->nomeUnidade;
    }
}
