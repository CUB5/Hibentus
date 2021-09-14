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
    private $id_evento;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participantes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_usuario;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdEvento(): ?Evento
    {
        return $this->id_evento;
    }

    public function setIdEvento(?Evento $id_evento): self
    {
        $this->id_evento = $id_evento;

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
