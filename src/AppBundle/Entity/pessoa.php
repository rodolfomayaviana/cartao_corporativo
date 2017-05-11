<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * pessoa
 *
 * @ORM\Table(name="pessoa")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\pessoaRepository")
 */
class pessoa
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
     * @ORM\Column(name="nomePessoa", type="string", length=255)
     */
    private $nomePessoa;


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
     * Set nomePessoa
     *
     * @param string $nomePessoa
     *
     * @return pessoa
     */
    public function setNomePessoa($nomePessoa)
    {
        $this->nomePessoa = $nomePessoa;

        return $this;
    }

    /**
     * Get nomePessoa
     *
     * @return string
     */
    public function getNomePessoa()
    {
        return $this->nomePessoa;
    }
}
