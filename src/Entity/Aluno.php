<?php

namespace App\Entity;

use App\Repository\AlunoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=AlunoRepository::class)
 */
class Aluno
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Este campo nao pode ser nulo")
     */
    private $Nome;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Este campo nao pode ser nulo")
     */
    private $Localidade;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->Nome;
    }

    public function setNome(string $Nome): self
    {
        $this->Nome = $Nome;

        return $this;
    }

    public function getLocalidade(): ?string
    {
        return $this->Localidade;
    }

    public function setLocalidade(string $Localidade): self
    {
        $this->Localidade = $Localidade;

        return $this;
    }
}
