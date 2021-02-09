<?php

namespace App\Entity;

use App\Repository\PackagingKindRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use JetBrains\PhpStorm\Pure;

/**
 * @ORM\Entity(repositoryClass=PackagingKindRepository::class)
 * @ORM\Table(name="packagin_kinds")
 */
class PackagingKind extends EntityKind
{
    /**
     * @ORM\ManyToOne(targetEntity=PackagingKind::class, inversedBy="packagingKinds")
     */
    private ?PackagingKind $parent = null;

    /**
     * @ORM\OneToMany(targetEntity=PackagingKind::class, mappedBy="parent")
     */
    private ArrayCollection|PersistentCollection $packagingKinds;

    #[Pure] public function __construct()
    {
        $this->packagingKinds = new ArrayCollection();
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getPackagingKinds(): Collection
    {
        return $this->packagingKinds;
    }

    public function addPackagingKind(self $packagingKind): self
    {
        if (!$this->packagingKinds->contains($packagingKind)) {
            $this->packagingKinds[] = $packagingKind;
            $packagingKind->setParent($this);
        }

        return $this;
    }

    public function removePackagingKind(self $packagingKind): self
    {
        if ($this->packagingKinds->removeElement($packagingKind)) {
            // set the owning side to null (unless already changed)
            if ($packagingKind->getParent() === $this) {
                $packagingKind->setParent(null);
            }
        }

        return $this;
    }
}
