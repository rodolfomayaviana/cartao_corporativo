<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Favorecido
 *
 * @ORM\Table(name="favorecido")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\FavorecidoRepository")
 */
class Favorecido
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
     * @ORM\Column(name="nomeFavorecido", type="string", length=255)
     */
    private $nomeFavorecido;


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
     * Set nomeFavorecido
     *
     * @param string $nomeFavorecido
     *
     * @return Favorecido
     */
    public function setNomeFavorecido($nomeFavorecido)
    {
        $this->nomeFavorecido = $nomeFavorecido;

        return $this;
    }

    /**
     * Get nomeFavorecido
     *
     * @return string
     */
    public function getNomeFavorecido()
    {
        return $this->nomeFavorecido;
    }

    public function __construct($idFavorecido , $nomeFavorecido) {

	$this->id = $idFavorecido;
	$this->nomeFavorecido = $nomeFavorecido; 
   }
}

