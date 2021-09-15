<?php

namespace App\Entity;

use App\Repository\ParticipanteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipanteRepository::class)
 */
class Participante
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Evento::class, inversedBy="participantes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idEvento;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participantes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEvento(): ?evento
    {
        return $this->idEvento;
    }

    public function setIdEvento(?evento $idEvento): self
    {
        $this->idEvento = $idEvento;

        return $this;
    }

    public function getIdUsuario(): ?User
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(?User $id_usuario): self
    {
        $this->id_usuario = $id_usuario;

        return $this;
    }
}
