<?php

namespace App\Entity;

use App\Repository\EmpleadoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: EmpleadoRepository::class)]
#[Gedmo\Loggable]
class Empleado
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Gedmo\Versioned]
    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Gedmo\Versioned]
    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[Gedmo\Versioned]
    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[Gedmo\Versioned]
    #[ORM\Column(length: 255)]
    private ?string $phone = null;

    #[Gedmo\Versioned]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthdate = null;

    #[Gedmo\Versioned]
    #[ORM\Column]
    private ?float $salary = null;

    #[Gedmo\Versioned]
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $contractdate = null;

    #[Gedmo\Versioned]
    #[ORM\Column]
    private ?bool $status = null;

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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirthdate(): ?\DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(\DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function getSalary(): ?float
    {
        return $this->salary;
    }

    public function setSalary(float $salary): static
    {
        $this->salary = $salary;

        return $this;
    }

    public function getContractdate(): ?\DateTimeInterface
    {
        return $this->contractdate;
    }

    public function setContractdate(\DateTimeInterface $contractdate): static
    {
        $this->contractdate = $contractdate;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): static
    {
        $this->status = $status;

        return $this;
    }
}
