<?php

namespace App\Entity;

use App\Repository\ProyectoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProyectoRepository::class)]
class Proyecto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $initdate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $finishdate = null;

    /**
     * @var Collection<int, Empleado>
     */
    #[ORM\ManyToMany(targetEntity: Empleado::class)]
    private Collection $asingemployed;

    #[ORM\Column(length: 255)]
    private ?string $no = null;

    public function __construct()
    {
        $this->asingemployed = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getInitdate(): ?\DateTimeInterface
    {
        return $this->initdate;
    }

    public function setInitdate(\DateTimeInterface $initdate): static
    {
        $this->initdate = $initdate;

        return $this;
    }

    public function getFinishdate(): ?\DateTimeInterface
    {
        return $this->finishdate;
    }

    public function setFinishdate(\DateTimeInterface $finishdate): static
    {
        $this->finishdate = $finishdate;

        return $this;
    }

    /**
     * @return Collection<int, Empleado>
     */
    public function getAsingemployed(): Collection
    {
        return $this->asingemployed;
    }

    public function addAsingemployed(Empleado $asingemployed): static
    {
        if (!$this->asingemployed->contains($asingemployed)) {
            $this->asingemployed->add($asingemployed);
        }

        return $this;
    }

    public function removeAsingemployed(Empleado $asingemployed): static
    {
        $this->asingemployed->removeElement($asingemployed);

        return $this;
    }

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): static
    {
        $this->no = $no;

        return $this;
    }
}
