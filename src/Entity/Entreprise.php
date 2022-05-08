<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, nullable: true)]
    private $designation;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Pfe::class)]
    private $pves;

    public function __construct()
    {
        $this->pves = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(?string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * @return Collection<int, Pfe>
     */
    public function getPves(): Collection
    {
        return $this->pves;
    }

    public function addPfe(Pfe $pfe): self
    {
        if (!$this->pves->contains($pfe)) {
            $this->pves[] = $pfe;
            $pfe->setEntreprise($this);
        }

        return $this;
    }


    public function removePfe(Pfe $pfe): self
    {
        if ($this->pves->removeElement($pfe)) {
            // set the owning side to null (unless already changed)
            if ($pfe->getEntreprise() === $this) {
                $pfe->setEntreprise(null);
            }
        }

        return $this;
    }
    public function __toString(): string
    {
        return $this->designation;
    }
}
