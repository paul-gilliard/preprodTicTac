<?php

namespace App\Entity;

use App\Repository\QuestionBDDMuseumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QuestionBDDMuseumRepository::class)
 */
class QuestionBDDMuseum
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
     * @ORM\OneToMany(targetEntity=QuestionValideeMuseum::class, mappedBy="idQuestionValide")
     */
    private $questionValideeMuseums;

    public function __construct()
    {
        $this->questionValideeMuseums = new ArrayCollection();
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
     * @return Collection|QuestionValideeMuseum[]
     */
    public function getQuestionValideeMuseums(): Collection
    {
        return $this->questionValideeMuseums;
    }

    public function addQuestionValideeMuseum(QuestionValideeMuseum $questionValideeMuseum): self
    {
        if (!$this->questionValideeMuseums->contains($questionValideeMuseum)) {
            $this->questionValideeMuseums[] = $questionValideeMuseum;
            $questionValideeMuseum->setIdQuestionValide($this);
        }

        return $this;
    }

    public function removeQuestionValideeMuseum(QuestionValideeMuseum $questionValideeMuseum): self
    {
        if ($this->questionValideeMuseums->removeElement($questionValideeMuseum)) {
            // set the owning side to null (unless already changed)
            if ($questionValideeMuseum->getIdQuestionValide() === $this) {
                $questionValideeMuseum->setIdQuestionValide(null);
            }
        }

        return $this;
    }
}
