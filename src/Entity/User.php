<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use function Symfony\Component\DependencyInjection\Loader\Configurator\ref;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 * @UniqueEntity(fields={"Username"},message="Username déjà utilisé"
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email()
     */
    private $email;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $niveauValide;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $note;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    public $confirm_password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Username;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $cookingDatabaseName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $museumDatabaseName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $compagnyDatabseName;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity=QuestionValideeCooking::class, mappedBy="idUser")
     */
    private $questionValideeCookings;

    /**
     * @ORM\OneToMany(targetEntity=QuestionValideeMuseum::class, mappedBy="idUser")
     */
    private $questionValideeMuseums;

    /**
     * @ORM\OneToMany(targetEntity=QuestionValideeCompagny::class, mappedBy="idUser")
     */
    private $questionValideeCompagnies;

    public function __construct()
    {
        $this->questionValideeCookings = new ArrayCollection();
        $this->questionValideeMuseums = new ArrayCollection();
        $this->questionValideeCompagnies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNiveauValide(): ?int
    {
        return $this->niveauValide;
    }

    public function setNiveauValide(?int $niveauValide): self
    {
        $this->niveauValide = $niveauValide;

        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(?int $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->Username;
    }

    public function setUsername(string $Username): self
    {
        $this->Username = $Username;

        return $this;
    }

    public function getUserIdentifier()
    {
        return $this->id;
    }

    public function getRoles()
    {
        if($this->roles == "ROLE_ADMIN"){
            return ['ROLE_ADMIN'];
        } else {
            return ['ROLE_USER'];
        }
        // 
        return $this->roles;
        // return $this->role;
    }
    public function getSalt()
    {
        
    }

    public function eraseCredentials()
    {
        
    }

    public function getCookingDatabaseName(): ?string
    {
        return $this->cookingDatabaseName;
    }

    public function setCookingDatabaseName(?string $cookingDatabaseName): self
    {
        $this->cookingDatabaseName = $cookingDatabaseName;

        return $this;
    }

    public function getMuseumDatabaseName(): ?string
    {
        return $this->museumDatabaseName;
    }

    public function setMuseumDatabaseName(?string $museumDatabaseName): self
    {
        $this->museumDatabaseName = $museumDatabaseName;

        return $this;
    }

    public function getCompagnyDatabseName(): ?string
    {
        return $this->compagnyDatabseName;
    }

    public function setCompagnyDatabseName(?string $compagnyDatabseName): self
    {
        $this->compagnyDatabseName = $compagnyDatabseName;

        return $this;
    }


    public function setRoles(string $roles): self
    {
        $this->roles = $roles;

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
            $questionValideeCooking->setIdUser($this);
        }

        return $this;
    }

    public function removeQuestionValideeCooking(QuestionValideeCooking $questionValideeCooking): self
    {
        if ($this->questionValideeCookings->removeElement($questionValideeCooking)) {
            // set the owning side to null (unless already changed)
            if ($questionValideeCooking->getIdUser() === $this) {
                $questionValideeCooking->setIdUser(null);
            }
        }

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
            $questionValideeMuseum->setIdUser($this);
        }

        return $this;
    }

    public function removeQuestionValideeMuseum(QuestionValideeMuseum $questionValideeMuseum): self
    {
        if ($this->questionValideeMuseums->removeElement($questionValideeMuseum)) {
            // set the owning side to null (unless already changed)
            if ($questionValideeMuseum->getIdUser() === $this) {
                $questionValideeMuseum->setIdUser(null);
            }
        }

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
            $questionValideeCompagny->setIdUser($this);
        }

        return $this;
    }

    public function removeQuestionValideeCompagny(QuestionValideeCompagny $questionValideeCompagny): self
    {
        if ($this->questionValideeCompagnies->removeElement($questionValideeCompagny)) {
            // set the owning side to null (unless already changed)
            if ($questionValideeCompagny->getIdUser() === $this) {
                $questionValideeCompagny->setIdUser(null);
            }
        }

        return $this;
    }
}
