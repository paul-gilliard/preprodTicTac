<?php

namespace App\Entity;

use App\Repository\QuestionValideeMuseumRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionValideeMuseumRepository::class)
 */
class QuestionValideeMuseum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="questionValideeMuseums")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionBDDMuseum::class, inversedBy="questionValideeMuseums")
     */
    private $idQuestionValide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdQuestionValide(): ?QuestionBDDMuseum
    {
        return $this->idQuestionValide;
    }

    public function setIdQuestionValide(?QuestionBDDMuseum $idQuestionValide): self
    {
        $this->idQuestionValide = $idQuestionValide;

        return $this;
    }
}
