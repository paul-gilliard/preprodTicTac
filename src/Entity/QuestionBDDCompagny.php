<?php

namespace App\Entity;

use App\Repository\QuestionBDDCompagnyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionBDDCompagnyRepository::class)
 */
class QuestionBDDCompagny
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
     * @ORM\OneToMany(targetEntity=QuestionValideeCompagny::class, mappedBy="idQuestionValide")
     */
    private $questionValideeCompagnies;

    public function __construct()
    {
        $this->questionValideeCompagnies = new ArrayCollection();
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
     * @return Collection|QuestionValideeCompagny[]
     */
    public function getQuestionValideeCompagnies(): Collection
    {
        return $this->questionValideeCompagnies;
    }

    public function addQuestionValideeCompagny(QuestionValideeCompagny $questionValideeCompagny): self
    {
        if (!$this->questionValideeCompagnies->contains($questionValideeCompagny)) {
            $this->questionValideeCompagnies[] = $questionValideeCompagny;
            $questionValideeCompagny->setIdQuestionValide($this);
        }

        return $this;
    }

    public function removeQuestionValideeCompagny(QuestionValideeCompagny $questionValideeCompagny): self
    {
        if ($this->questionValideeCompagnies->removeElement($questionValideeCompagny)) {
            // set the owning side to null (unless already changed)
            if ($questionValideeCompagny->getIdQuestionValide() === $this) {
                $questionValideeCompagny->setIdQuestionValide(null);
            }
        }

        return $this;
    }
}
