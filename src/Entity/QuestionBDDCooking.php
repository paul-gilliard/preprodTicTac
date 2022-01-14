<?php

namespace App\Entity;

use App\Repository\QuestionBDDCookingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionBDDCookingRepository::class)
 */
class QuestionBDDCooking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $intitule_question;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reponse;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $numero_question;

    /**
     * @ORM\OneToMany(targetEntity=QuestionValideeCooking::class, mappedBy="idQuestionValide")
     */
    private $questionValideeCookings;

    public function __construct()
    {
        $this->questionValideeCookings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntituleQuestion(): ?string
    {
        return $this->intitule_question;
    }

    public function setIntituleQuestion(string $intitule_question): self
    {
        $this->intitule_question = $intitule_question;

        return $this;
    }

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getNumeroQuestion(): ?int
    {
        return $this->numero_question;
    }

    public function setNumeroQuestion(?int $numero_question): self
    {
        $this->numero_question = $numero_question;

        return $this;
    }

    /**
     * @return Collection|QuestionValideeCooking[]
     */
    public function getQuestionValideeCookings(): Collection
    {
        return $this->questionValideeCookings;
    }

    public function addQuestionValideeCooking(QuestionValideeCooking $questionValideeCooking): self
    {
        if (!$this->questionValideeCookings->contains($questionValideeCooking)) {
            $this->questionValideeCookings[] = $questionValideeCooking;
            $questionValideeCooking->setIdQuestionValide($this);
        }

        return $this;
    }

    public function removeQuestionValideeCooking(QuestionValideeCooking $questionValideeCooking): self
    {
        if ($this->questionValideeCookings->removeElement($questionValideeCooking)) {
            // set the owning side to null (unless already changed)
            if ($questionValideeCooking->getIdQuestionValide() === $this) {
                $questionValideeCooking->setIdQuestionValide(null);
            }
        }

        return $this;
    }
}
