<?php

namespace App\Entity;

use App\Repository\QuestionValideeCookingRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=QuestionValideeCookingRepository::class)
 * @UniqueEntity("id_user_id", message="Un article existe déjà avec ce titre.") // c'est ici que je declare le champs unique
 */
class QuestionValideeCooking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=user::class, inversedBy="questionValideeCookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idUser;

    /**
     * @ORM\ManyToOne(targetEntity=QuestionBDDCooking::class, inversedBy="questionValideeCookings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $idQuestionValide;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdUser(): ?user
    {
        return $this->idUser;
    }

    public function setIdUser(?user $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdQuestionValide(): ?QuestionBDDCooking
    {
        return $this->idQuestionValide;
    }

    public function setIdQuestionValide(?QuestionBDDCooking $idQuestionValide): self
    {
        $this->idQuestionValide = $idQuestionValide;

        return $this;
    }
}
