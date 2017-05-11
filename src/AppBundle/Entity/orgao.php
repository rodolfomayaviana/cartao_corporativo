<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * orgao
 *
 * @ORM\Table(name="orgao")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\orgaoRepository")
 */
class orgao
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
     * Get nomeOrgao
     *
     * @return string
     */
    public function getNomeOrgao()
    {
        return $this->nomeOrgao;
    }
}
