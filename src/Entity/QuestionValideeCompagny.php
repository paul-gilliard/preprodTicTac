<?php

namespace App\Entity;

use App\Repository\QuestionValideeCompagnyRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionValideeCompagnyRepository::class)
 */
class QuestionValideeCompagny
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="questionValideeCompagnies")
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionBDDCompagny::class, inversedBy="questionValideeCompagnies")
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

    public function getIdQuestionValide(): ?QuestionBDDCompagny
    {
        return $this->idQuestionValide;
    }

    public function setIdQuestionValide(?QuestionBDDCompagny $idQuestionValide): self
    {
        $this->idQuestionValide = $idQuestionValide;

        return $this;
    }
}
